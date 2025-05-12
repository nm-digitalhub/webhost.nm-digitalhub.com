#!/bin/bash

# קובץ היעד
APP_FILE="bootstrap/app.php"

# גיבוי הקובץ המקורי
cp "$APP_FILE" "${APP_FILE}.bak"

# בדיקה אם הקובץ קיים
if [ ! -f "$APP_FILE" ]; then
  echo "❌ הקובץ $APP_FILE לא נמצא."
  exit 1
fi

# בדיקה אם ה־middleware כבר מוגדר
if grep -q "auth:sanctum" "$APP_FILE"; then
  echo "✔️ ה־middleware של Sanctum כבר מוגדר."
  exit 0
fi

# הוספת ה־middleware
echo "➕ מוסיף את ה־middleware של Sanctum..."

# הוספת השורה המתאימה לפני השורה '->create();'
sed -i "/->create();/i \        ->withMiddleware(function (Middleware \$middleware) {\n            \$middleware->alias([\n                'auth:sanctum' => \\\Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful::class,\n            ]);\n        })" "$APP_FILE"

# בדיקה אם ההוספה הצליחה
if grep -q "auth:sanctum" "$APP_FILE"; then
  echo "✅ ה־middleware נוסף בהצלחה."
else
  echo "❌ שגיאה בהוספת ה־middleware."
  # שחזור מהגיבוי
  mv "${APP_FILE}.bak" "$APP_FILE"
  exit 1
fi
