#!/bin/bash

# נתיב הקובץ .env
ENV_FILE=".env"

# מפתח משתנה עבור ה-API
KEY_NAME="SCAN_API_KEY"

# בדוק אם קובץ .env קיים, צור אם לא
if [ ! -f "$ENV_FILE" ]; then
    echo "🔧 יוצרים קובץ .env חדש..."
    touch "$ENV_FILE"
fi

# בדוק אם המפתח כבר מוגדר
if grep -q "^$KEY_NAME=" "$ENV_FILE"; then
    API_KEY=$(grep "^$KEY_NAME=" "$ENV_FILE" | cut -d '=' -f2)
    echo "🔐 נמצא API KEY קיים: $API_KEY"
else
    # צור מפתח חדש באורך 32 תווים
    API_KEY=$(openssl rand -hex 16)
    echo "$KEY_NAME=$API_KEY" >> "$ENV_FILE"
    echo "🔑 נוצר API KEY חדש ונשמר: $API_KEY"
fi

# כתובת ה-API
API_URL="https://webhost.nm-digitalhub.com/api/scan-code"

# שם קובץ הפלט
OUTPUT_FILE="scanned_code.json"

echo "🔍 שולח בקשה ל-API..."
curl -s -H "X-API-KEY: $API_KEY" "$API_URL" -o "$OUTPUT_FILE"

if [ -s "$OUTPUT_FILE" ]; then
    echo "✅ קוד התקבל ונשמר בקובץ $OUTPUT_FILE"
    jq length "$OUTPUT_FILE"
else
    echo "❌ הבקשה נכשלה או הקובץ ריק."
fi
