#!/bin/bash

API_URL="https://webhost.nm-digitalhub.com" # שנה לפי הדומיין שלך
EMAIL="admin@example.com"
PASSWORD="90ULHsi0FyP5NNTL"

echo "🔐 התחברות למערכת ובדיקת טוקן Sanctum..."

# ביצוע התחברות
RESPONSE=$(curl -s -X POST "$API_URL/login" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"$EMAIL\", \"password\":\"$PASSWORD\"}")

# חילוץ הטוקן
TOKEN=$(echo "$RESPONSE" | grep -oP '"token"\s*:\s*"\K[^"]+')

if [ -z "$TOKEN" ]; then
  echo "❌ לא התקבל טוקן. תגובת השרת:"
  echo "$RESPONSE"
  exit 1
else
  echo "✅ טוקן התקבל:"
  echo "$TOKEN"
fi

# בדיקת שימוש בטוקן
USER_RESPONSE=$(curl -s -X GET "$API_URL/api/user" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN")

echo -e "\n👤 תגובת הבדיקה עם הטוקן:"
echo "$USER_RESPONSE"
