#!/bin/bash

EXPORT_DIR="export_resources"
LOG_FILE="resource_paths.log"
ZIP_NAME="resources_for_review.zip"

# ודא שהתיקיה קיימת
if [ ! -d "$EXPORT_DIR" ]; then
  echo "Error: Directory $EXPORT_DIR does not exist."
  exit 1
fi

# צור קובץ zip כולל הלוג
zip -r "$ZIP_NAME" "$EXPORT_DIR" "$LOG_FILE"

echo "== Compression Complete =="
echo "Created archive: $ZIP_NAME"
