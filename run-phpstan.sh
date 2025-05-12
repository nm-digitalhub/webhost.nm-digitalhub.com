#!/bin/bash

# Script to run PHPStan with increased memory limit

# Clear any cached files
rm -rf storage/framework/cache/phpstan
mkdir -p storage/framework/cache/phpstan

# Run PHPStan with increased memory limit
php -d memory_limit=512M vendor/bin/phpstan analyse --memory-limit=512M "$@"

# Check exit status
if [ $? -eq 0 ]; then
    echo "PHPStan analysis completed successfully!"
else
    echo "PHPStan analysis completed with errors."
fi
