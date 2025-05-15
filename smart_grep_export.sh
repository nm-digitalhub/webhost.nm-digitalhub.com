#!/bin/bash

# הגדרת משתנה החיפוש (לדוגמה: ListClientModules)
SEARCH_TERM="${1:-ListClientModules}"
OUTPUT_FILE="${2:-grep_output_${SEARCH_TERM}.txt}"

echo "Smart search for '$SEARCH_TERM' across PHP files..." > "$OUTPUT_FILE"
echo "Output file: $OUTPUT_FILE" >> "$OUTPUT_FILE"
echo "----------------------------------------" >> "$OUTPUT_FILE"

# פונקציית סיווג
classify_match() {
    local line="$1"
    if [[ "$line" == *"use "*"$SEARCH_TERM"* ]]; then
        echo "[USE]      $line"
    elif [[ "$line" == *"extends "*"$SEARCH_TERM"* ]]; then
        echo "[EXTENDS]  $line"
    elif [[ "$line" == *"new "*"$SEARCH_TERM"* ]]; then
        echo "[NEW]      $line"
    elif [[ "$line" == *"route("*"$SEARCH_TERM"* ]]; then
        echo "[ROUTE]    $line"
    else
        echo "[UNKNOWN]  $line"
    fi
}

# חיפוש קבצים רלוונטיים
grep -rn --include="*.php" --exclude-dir={vendor,node_modules,storage} "$SEARCH_TERM" . | while IFS= read -r line; do
    FILE=$(echo "$line" | cut -d: -f1)
    LINENUM=$(echo "$line" | cut -d: -f2)
    CODE=$(echo "$line" | cut -d: -f3-)
    
    CLASSIFIED=$(classify_match "$CODE")
    echo "$FILE:$LINENUM: $CLASSIFIED" >> "$OUTPUT_FILE"
done

echo "Search completed. Results saved to $OUTPUT_FILE"
