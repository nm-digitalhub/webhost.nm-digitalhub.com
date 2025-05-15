#!/bin/bash

MISSING_FILE="missing_isEmailVerificationRequired.txt"

while read -r file; do
    if grep -q 'function isEmailVerificationRequired' "$file"; then
        echo "Skipped (already exists): $file"
    else
        echo "Patching: $file"
        # גיבוי
        cp "$file" "$file.bak"

        # הוספת המתודה לפני הסוגר האחרון של המחלקה
        sed -i '' -e '$ i\
    public static function isEmailVerificationRequired(\\Filament\\Panel $panel): bool\
    {\
        return $panel->isEmailVerificationRequired();\
    }\
' "$file"
    fi
done < "$MISSING_FILE"
