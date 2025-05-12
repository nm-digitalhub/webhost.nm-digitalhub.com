#!/bin/bash

# קובץ היעד
OUTPUT="project_structure.md"

# תיקיית הבסיס
BASE_DIR="${1:-.}"

echo "# Project Structure Documentation" > "$OUTPUT"
echo "" >> "$OUTPUT"
echo "📁 Scanned directory: \`$BASE_DIR\`" >> "$OUTPUT"
echo "" >> "$OUTPUT"

# פונקציה להצגת מבנה התיקיות
print_structure() {
    echo "## Directory Tree" >> "$OUTPUT"
    echo "" >> "$OUTPUT"
    echo '```' >> "$OUTPUT"
    tree -a -I 'vendor|node_modules|.git|storage|bootstrap/cache' "$BASE_DIR" >> "$OUTPUT"
    echo '```' >> "$OUTPUT"
    echo "" >> "$OUTPUT"
}

# סטטיסטיקות לפי סוג
print_stats() {
    echo "## File Type Statistics" >> "$OUTPUT"
    echo "" >> "$OUTPUT"

    declare -A types=(
        ["Controllers"]="app/Http/Controllers/*.php"
        ["Livewire Components"]="app/Livewire/**/*.php"
        ["Filament Resources"]="app/Filament/Resources/**/*.php"
        ["Blade Views"]="resources/views/**/*.blade.php"
        ["Migrations"]="database/migrations/*.php"
        ["Routes"]="routes/*.php"
        ["Middleware"]="app/Http/Middleware/*.php"
        ["Models"]="app/Models/*.php"
    )

    for label in "${!types[@]}"; do
        pattern="${types[$label]}"
        count=$(find $pattern 2>/dev/null | wc -l)
        echo "- **$label**: $count file(s)" >> "$OUTPUT"
    done

    echo "" >> "$OUTPUT"
}

# הפעלת הפונקציות
print_structure
print_stats

echo "✅ Done! Structure written to: $OUTPUT"
