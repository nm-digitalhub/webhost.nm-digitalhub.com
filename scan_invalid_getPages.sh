#!/bin/bash

echo "=== Scanning for invalid getPages() definitions ==="
echo ""

BASE_DIR="app/Filament/Resources"
FOUND=0

find "$BASE_DIR" -type f -name "*.php" | while read file; do
    if grep -q "function getPages" "$file"; then
        if grep -E "'\s*=>\s*Pages\\\\[A-Za-z]+" "$file" >/dev/null; then
            echo "⚠️  Potential legacy getPages() found in: $file"
            grep -A 5 "function getPages" "$file" | sed 's/^/    /'
            echo ""
            FOUND=$((FOUND+1))
        fi
    fi
done

if [ "$FOUND" -eq 0 ]; then
    echo "✅ All getPages() methods appear to be compatible with Filament 3."
else
    echo "⚠️  Found $FOUND resource file(s) with outdated getPages() definitions."
    echo "Please update them to return an array of Page::class references."
fi
