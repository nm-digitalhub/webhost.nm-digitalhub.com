#!/bin/bash

# תיקייה זמנית
TEMP_DIR="unregistered_resources_temp"
ZIP_NAME="unregistered_resources.zip"

# מיקום קבצי המשאבים
RESOURCE_DIR="app/Filament/Resources"
ADMIN_PROVIDER="app/Providers/Filament/AdminPanelProvider.php"

# קובץ פלט
OUTPUT_FILE="unregistered_resources.txt"

# ניקוי ישן
rm -rf $TEMP_DIR $ZIP_NAME $OUTPUT_FILE
mkdir -p $TEMP_DIR

echo "סורק משאבים בתיקייה: $RESOURCE_DIR"
echo "בודק רישום בקובץ: $ADMIN_PROVIDER"
echo "" > $OUTPUT_FILE

# עבור כל Resource.php
for FILE in $(find $RESOURCE_DIR -type f -name "*Resource.php"); do
    CLASS_NAME=$(basename "$FILE" .php)
    
    if grep -q "$CLASS_NAME" "$ADMIN_PROVIDER"; then
        echo "[✔] $CLASS_NAME רשום בפאנל" >> $OUTPUT_FILE
    else
        echo "[✖] $CLASS_NAME לא רשום בפאנל" >> $OUTPUT_FILE
        cp --parents "$FILE" $TEMP_DIR/
    fi
done

# העתק את AdminPanelProvider לצורך בדיקה ידנית
cp --parents "$ADMIN_PROVIDER" $TEMP_DIR/

# העתק קובץ הפלט
cp "$OUTPUT_FILE" $TEMP_DIR/

# אריזת הקבצים
zip -r "$ZIP_NAME" $TEMP_DIR > /dev/null

# ניקוי זמני
rm -rf $TEMP_DIR

echo ""
echo "המשאבים הלא רשומים נארזו בקובץ: $ZIP_NAME"
echo "רשימת המשאבים נשמרה ב־$OUTPUT_FILE"
