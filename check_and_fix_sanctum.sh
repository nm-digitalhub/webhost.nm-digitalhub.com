#!/bin/bash

echo "--------------------------------------"
echo "🛠️  בדיקת ותיקון הגדרת Laravel Sanctum"
echo "--------------------------------------"

# נתיב בסיס לפרויקט Laravel שלך
PROJECT_DIR="/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com"
cd "$PROJECT_DIR" || { echo "❌ לא ניתן לגשת לתיקייה: $PROJECT_DIR"; exit 1; }

USER_FILE="app/Models/User.php"
KERNEL_FILE="app/Http/Kernel.php"
API_ROUTE="routes/api.php"

echo -e "\n🔍 בדיקה: שימוש ב-HasApiTokens במודל User:"
if grep -q "use HasApiTokens;" "$USER_FILE"; then
  echo "✔️  HasApiTokens כבר קיים"
else
  echo "➕ מוסיף use HasApiTokens;..."
  sed -i "/use Illuminate\\\\Foundation\\\\Auth\\\\User as Authenticatable;/a use Laravel\\\Sanctum\\\HasApiTokens;" "$USER_FILE"
fi

echo -e "\n🔍 בדיקה: הכנסת ה-Trait לקלאס User:"
if grep -q "use HasApiTokens, HasFactory" "$USER_FILE"; then
  echo "✔️  HasApiTokens בשורת traits"
else
  sed -i "s/use HasFactory;/use HasApiTokens, HasFactory;/g" "$USER_FILE"
  echo "➕ trait HasApiTokens נוסף"
fi

echo -e "\n🔍 בדיקה: middleware בקובץ Kernel:"
if grep -q "EnsureFrontendRequestsAreStateful::class" "$KERNEL_FILE"; then
  echo "✔️  middleware של Sanctum קיים"
else
  echo "➕ מוסיף middleware Sanctum לקבוצת api..."
  sed -i "/'api' => \[/a \ \ \ \ \ \ \ \ \Laravel\\\Sanctum\\\Http\\\Middleware\\\EnsureFrontendRequestsAreStateful::class," "$KERNEL_FILE"
fi

echo -e "\n🔍 בדיקה: קיום config/sanctum.php"
if [ -f "config/sanctum.php" ]; then
  echo "✔️  sanctum.php קיים"
else
  echo "📦 מפרסם sanctum.php..."
  php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider" --force
fi

echo -e "\n🔍 בדיקה: קיום route עם auth:sanctum"
if grep -q "auth:sanctum" "$API_ROUTE"; then
  echo "✔️  auth:sanctum מוגדר ב-api.php"
else
  echo "➕ מוסיף דוגמת route עם auth:sanctum..."
  cat <<EOL >> "$API_ROUTE"

Route::middleware('auth:sanctum')->get('/user-check', function (Request \$request) {
    return ['user' => \$request->user()];
});
EOL
fi

echo -e "\n🔍 בדיקה: קיום טבלת personal_access_tokens"
php artisan tinker --execute="echo Schema::hasTable('personal_access_tokens') ? '✔️ קיימת' : '❌ חסרה';" || echo "⚠️ לא ניתן להריץ בדיקת טבלה"

echo -e "\n✅ סקריפט הסתיים. ייתכן שתצטרך להריץ:"
echo "   ➤ php artisan migrate --force"
echo "   ➤ php artisan config:clear && php artisan route:clear"
