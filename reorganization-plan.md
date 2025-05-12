# Laravel 12 Project Restructuring Plan

## Overview
This document outlines the step-by-step process for reorganizing the NM-DigitalHUB Laravel 12 project to follow the standard structure and best practices for Laravel 12, Filament 3, and Livewire.

## Backup Procedure
Before making any changes, create a comprehensive backup:

```bash
# Navigate to the project root
cd /var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com

# Create a timestamped backup
timestamp=$(date +%Y-%m-%d_%H-%M-%S)
tar -czf "/tmp/nm-digitalhub-backup-$timestamp.tar.gz" \
    --exclude="./vendor" \
    --exclude="./node_modules" \
    --exclude="./.git" \
    .

# Verify backup file was created
ls -la "/tmp/nm-digitalhub-backup-$timestamp.tar.gz"
