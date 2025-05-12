#!/bin/bash

# הגדרת שם קובץ הארכיון עם תאריך
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M")
ZIP_NAME="config_backup_$TIMESTAMP.zip"
LOG_FILE="config_files_list_$TIMESTAMP.log"

# מיקום תיקיית config
CONFIG_DIR="config"

# בדיקה שהתיקייה קיימת
if [ ! -d "$CONFIG_DIR" ]; then
    echo "❌ לא נמצאה תיקייה בשם 'config'"
    exit 1
fi

# ייצוא שמות הקבצים ללוג
echo "== קבצים שנארזו ==" > "$LOG_FILE"
find "$CONFIG_DIR" -type f >> "$LOG_FILE"

# אריזת התיקייה
zip -r "$ZIP_NAME" "$CONFIG_DIR" > /dev/null

echo "✅ האריזה הושלמה: $ZIP_NAME"
echo "📄 רשימת קבצים: $LOG_FILE"
