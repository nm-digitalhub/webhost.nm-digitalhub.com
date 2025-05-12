#!/bin/bash

# הגדרת משתנים
DATE=$(date +"%Y-%m-%d_%H-%M")
ZIP_NAME="project_clean_$DATE.zip"
LOG_NAME="zip_file_list_$DATE.txt"

echo "רשימת הקבצים שייכנסו לאריזה נשמרת ב: $LOG_NAME"
echo "יוצר קובץ ZIP בשם: $ZIP_NAME"

# יצירת רשימת הקבצים שייכנסו
find . -type f \
  ! -path "./vendor/*" \
  ! -path "./node_modules/*" \
  ! -path "./storage/logs/*" \
  ! -path "./storage/framework/cache/*" \
  ! -path "./bootstrap/cache/*" \
  ! -path "./.git/*" \
  ! -name ".env" \
  ! -name "*.log" \
  ! -name "*.zip" \
  > "$LOG_NAME"

# יצירת קובץ ZIP
zip -r "$ZIP_NAME" . \
  -x "vendor/*" \
  -x "node_modules/*" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "bootstrap/cache/*" \
  -x ".git/*" \
  -x "*.log" \
  -x "*.zip" \
  -x ".env"

echo "סיום. הקובץ $ZIP_NAME נוצר."
