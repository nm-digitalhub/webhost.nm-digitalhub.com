#!/bin/bash

echo "מעבד את כל קבצי המיגרציה..."

for file in database/migrations/*.php; do
    echo "– בודק $file"

    # מוצא את כל שמות הטבלאות בקובץ
    grep -oP "Schema::create\s*\(\s*['\"]\K[^'\"]+" "$file" | while read -r table; do
        echo "   • מטפל בטבלה: $table"

        # מגבה את הקובץ רק פעם אחת
        [[ ! -f "$file.bak" ]] && cp "$file" "$file.bak"

        # מוסיף תנאי אחרי הפונקציה up()
        awk -v tbl="$table" '
        /public function up\(\)/ {
            print;
            getline;
            print "        if (!Schema::hasTable(\"" tbl "\")) {";
        }
        /Schema::create\([\"'"'"']" tbl "[\"'"'"']/ {
            print;
            next;
        }
        /^}$/ && inside == 0 {
            print "        }";
            inside = 1;
        }
        { print }
        ' "$file.bak" > "$file.tmp" && mv "$file.tmp" "$file"
    done
done

echo "✔️ הסתיים. כל מיגרציה רלוונטית נעטפה עם תנאי hasTable. גיבויים ב־*.bak"