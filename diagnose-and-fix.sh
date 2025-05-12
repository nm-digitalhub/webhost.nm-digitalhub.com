#!/bin/bash

LOG_FILE="diagnostic.log"
exec > >(tee -i $LOG_FILE)
exec 2>&1

echo "== PHPStan Analysis =="
vendor/bin/phpstan analyse --memory-limit=512M --error-format=table

echo ""
echo "== Rector Fixing =="
vendor/bin/rector process

echo ""
echo "== Laravel Cache Clear =="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "== DONE =="
