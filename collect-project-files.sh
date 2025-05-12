#!/bin/bash

# הגדרות כלליות
DATE=$(date +%Y-%m-%d_%H-%M)
ARCHIVE_NAME="files_for_review_$DATE.zip"
WORKDIR="/tmp/project_review_$DATE"
LOGFILE="$WORKDIR/diagnostic.log"

mkdir -p "$WORKDIR"

echo "== Starting diagnostic and file collection =="

# יצירת הלוג
{
    echo "== PHPStan Analysis =="
    vendor/bin/phpstan analyse --memory-limit=512M --error-format=table || echo "[PHPStan] Analysis completed with warnings"

    echo ""
    echo "== Rector Fixing Preview =="
    vendor/bin/rector process --dry-run || echo "[Rector] Dry-run completed with issues"

    echo ""
    echo "== Laravel Cache Clear =="
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear

    echo ""
    echo "== DONE =="
} > "$LOGFILE" 2>&1

echo "== Copying relevant project files =="

# קבצי PHP
cp -r app/Livewire "$WORKDIR/app_Livewire" 2>/dev/null
cp -r app/Http/Livewire "$WORKDIR/app_Http_Livewire" 2>/dev/null
cp -r app/Http/Controllers "$WORKDIR/app_Http_Controllers" 2>/dev/null

# תצוגות
mkdir -p "$WORKDIR/resources/views"
cp -r resources/views/livewire "$WORKDIR/resources/views/" 2>/dev/null
cp -r resources/views/vendor/filament-panels/components "$WORKDIR/resources/views/vendor/filament-panels/" 2>/dev/null

# קבצי תצורה ו־routes
cp routes/web.php "$WORKDIR/" 2>/dev/null
cp config/filament.php "$WORKDIR/" 2>/dev/null
cp composer.json "$WORKDIR/" 2>/dev/null
cp phpstan.neon "$WORKDIR/" 2>/dev/null

# יצירת הארכיון
cd /tmp || exit
zip -r "$ARCHIVE_NAME" "$(basename "$WORKDIR")" >/dev/null

# העברה חזרה לספריית הפרויקט
mv "$ARCHIVE_NAME" "$OLDPWD/"
rm -rf "$WORKDIR"

echo "== Archive created: $ARCHIVE_NAME =="
