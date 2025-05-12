#!/bin/bash

# This script runs PHPStan on different parts of the project to reduce memory usage

# Make sure run-phpstan.sh is executable
chmod +x run-phpstan.sh

echo "Analyzing Controllers..."
./run-phpstan.sh app/Http/Controllers

echo "Analyzing Models..."
./run-phpstan.sh app/Models

echo "Analyzing Routes..."
./run-phpstan.sh routes

echo "Analyzing Middleware..."
./run-phpstan.sh app/Http/Middleware

echo "Complete analysis finished!"
echo "Note: Filament resources were excluded to avoid memory issues."
