#!/bin/bash

# הגדרת נתיב הפרויקט
PROJECT_DIR="/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com"
cd "$PROJECT_DIR" || exit 1

# קובץ הדוח
REPORT_FILE="sanctum_admin_report.txt"
echo "📄 דוח הגדרת Sanctum ומנהל מערכת" > "$REPORT_FILE"
echo "תאריך: $(date)" >> "$REPORT_FILE"
echo "--------------------------------------" >> "$REPORT_FILE"

# בדיקה: שימוש ב-HasApiTokens במודל User
echo -e "\n🔍 בדיקה: שימוש ב-HasApiTokens במודל User:" >> "$REPORT_FILE"
if grep -q "use HasApiTokens;" app/Models/User.php; then
  echo "✔️  HasApiTokens מוגדר במודל User" >> "$REPORT_FILE"
else
  echo "❌  חסר use HasApiTokens; במודל User.php" >> "$REPORT_FILE"
fi

# בדיקה: middleware בקובץ bootstrap/app.php
echo -e "\n🔍 בדיקה: middleware בקובץ bootstrap/app.php:" >> "$REPORT_FILE"
if grep -q "statefulApi" bootstrap/app.php; then
  echo "✔️  middleware של Sanctum מוגדר ב-bootstrap/app.php" >> "$REPORT_FILE"
else
  echo "❌  middleware של Sanctum חסר ב-bootstrap/app.php" >> "$REPORT_FILE"
fi

# בדיקה: קיום קובץ config/sanctum.php
echo -e "\n🔍 בדיקה: קיום קובץ config/sanctum.php:" >> "$REPORT_FILE"
if [ -f "config/sanctum.php" ]; then
  echo "✔️  קובץ sanctum.php קיים" >> "$REPORT_FILE"
else
  echo "❌  קובץ sanctum.php לא קיים" >> "$REPORT_FILE"
fi

# בדיקה: קיום route עם auth:sanctum
echo -e "\n🔍 בדיקה: קיום route עם auth:sanctum:" >> "$REPORT_FILE"
if grep -q "auth:sanctum" routes/api.php; then
  echo "✔️  auth:sanctum מוגדר ב-api.php" >> "$REPORT_FILE"
else
  echo "❌  auth:sanctum לא מוגדר ב-api.php" >> "$REPORT_FILE"
fi

# בדיקה: קיום טבלת personal_access_tokens
echo -e "\n🔍 בדיקה: קיום טבלת personal_access_tokens:" >> "$REPORT_FILE"
php artisan tinker --execute="echo Schema::hasTable('personal_access_tokens') ? '✔️ קיימת' : '❌ חסרה';" >> "$REPORT_FILE"

# יצירת משתמש מנהל אם אינו קיים
echo -e "\n🔧 יצירת משתמש מנהל:" >> "$REPORT_FILE"
ADMIN_EMAIL="admin@example.com"
ADMIN_NAME="Admin User"
ADMIN_PASSWORD=$(openssl rand -base64 12)

if php artisan tinker --execute="echo App\Models\User::where('email', '$ADMIN_EMAIL')->exists() ? 'קיים' : 'חסר';" | grep -q "חסר"; then
  php artisan tinker --execute="App\Models\User::create(['name' => '$ADMIN_NAME', 'email' => '$ADMIN_EMAIL', 'password' => bcrypt('$ADMIN_PASSWORD')]);"
  echo "✔️  משתמש מנהל נוצר בהצלחה." >> "$REPORT_FILE"
  echo "   📧 אימייל: $ADMIN_EMAIL" >> "$REPORT_FILE"
  echo "   🔑 סיסמה: $ADMIN_PASSWORD" >> "$REPORT_FILE"
else
  echo "ℹ️  משתמש מנהל כבר קיים." >> "$REPORT_FILE"
fi

echo -e "\n✅ הבדיקות הסתיימו. הדוח נשמר בקובץ $REPORT_FILE"
