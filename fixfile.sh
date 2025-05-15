#!/bin/bash

# רשימת הקבצים לפרויקט שלך
FILES=$(find app/Filament/Resources -type f -name '*.php' | grep -v '/Pages/')

for FILE in $FILES; do
    echo "בודק קובץ: $FILE"
    
    # האם הקובץ כבר מכיל את המתודה?
    if grep -q 'function isEmailVerificationRequired' "$FILE"; then
        echo "  המתודה כבר קיימת. מדלג."
        continue
    fi

    # מציאת השורה האחרונה של המחלקה לפני סוגר הסיום
    LINE=$(grep -n '^\}' "$FILE" | tail -n 1 | cut -d: -f1)
    
    if [[ -z "$LINE" ]]; then
        echo "  שגיאה: לא נמצאה סגירת מחלקה בקובץ $FILE"
        continue
    fi

    # יצירת בלוק המתודה
    FUNCTION_CODE=$'\n    public static function isEmailVerificationRequired(\\Filament\\Panel $panel): bool\n    {\n        return $panel->isEmailVerificationRequired();\n    }\n'

    # הכנסת המתודה לפני סוגר המחלקה
    head -n $(($LINE - 1)) "$FILE" > "$FILE.tmp"
    echo "$FUNCTION_CODE" >> "$FILE.tmp"
    tail -n +$LINE "$FILE" >> "$FILE.tmp"
    mv "$FILE.tmp" "$FILE"

    echo "  נוסף בהצלחה."
done
