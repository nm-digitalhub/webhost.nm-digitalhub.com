#!/bin/bash
set -e

echo "Starting Livewire directory structure validation and migration..."

# Check Livewire version
echo "Checking Livewire version..."
if grep -q "livewire/livewire" composer.json; then
    livewire_version=$(grep -oP '"livewire/livewire"\s*:\s*"\K[^"]+' composer.json)
    echo "Found Livewire version: $livewire_version"
    
    # Determine proper directory structure based on version
    if [[ "$livewire_version" =~ ^3\. ]]; then
        echo "Livewire 3 detected - should use app/Livewire/ structure"
        CORRECT_NAMESPACE="App\\\\Livewire"
        LEGACY_NAMESPACE="App\\\\Http\\\\Livewire"
    else 
        echo "Livewire 2 detected - should use app/Http/Livewire/ structure"
        CORRECT_NAMESPACE="App\\\\Http\\\\Livewire"
        LEGACY_NAMESPACE="App\\\\Livewire"
    fi
else
    echo "Livewire package not detected in composer.json"
    # Assume Livewire 3 for safety
    CORRECT_NAMESPACE="App\\\\Livewire"
    LEGACY_NAMESPACE="App\\\\Http\\\\Livewire"
fi

# Create backup directory
mkdir -p app/Livewire/Admin/backup

# Check if the nested Admin directory exists
if [ -d "app/Livewire/Admin/Admin" ]; then
    echo "Found nested Admin directory"

    # Check for duplicate files and correct namespaces
    for file in app/Livewire/Admin/Admin/*.php; do
        if [ -f "$file" ]; then
            filename=$(basename "$file")
            # Skip AdminLayout as we've already handled it
            if [ "$filename" != "AdminLayout.php" ]; then
                # Check if file already exists in parent directory
                if [ -f "app/Livewire/Admin/$filename" ]; then
                    echo "WARNING: Duplicate file found: $filename"
                    # Copy to backup with .duplicate extension
                    cp "$file" "app/Livewire/Admin/backup/$filename.duplicate"
                else
                    echo "Migrating file: $filename"
                    # Correct namespace and copy file
                    sed 's/namespace App\\Http\\Livewire\\Admin;/namespace App\\Livewire\\Admin;/g' "$file" > "app/Livewire/Admin/$filename"
                    cp "$file" "app/Livewire/Admin/backup/$filename.original"
                fi
            fi
        fi
    done

    # Safely remove the redundant directory after everything is migrated
    echo "Removing redundant directory: app/Livewire/Admin/Admin"
    rm -rf app/Livewire/Admin/Admin

    # Check if backup is needed
    if [ -z "$(ls -A app/Livewire/Admin/backup)" ]; then
        echo "No files needed backup, removing backup directory"
        rm -rf app/Livewire/Admin/backup
    else
        echo "WARNING: Found additional files in nested Admin directory."
        echo "Review files in app/Livewire/Admin/backup before deleting"
        echo "Run: ls -la app/Livewire/Admin/backup"
    fi
else
    echo "No nested Admin directory found, structure is correct"
    rm -rf app/Livewire/Admin/backup
fi

# Verify all components use the correct namespace
echo "Checking namespaces in Livewire components..."
grep -l "namespace App\\\\Http\\\\Livewire\\\\Admin" app/Livewire/Admin/*.php | while read -r file; do
    echo "Fixing namespace in: $file"
    sed -i '' 's/namespace App\\Http\\Livewire\\Admin;/namespace App\\Livewire\\Admin;/g' "$file" || echo "Failed to update $file, please fix manually"
done

echo "Migration complete. Please review changes and test functionality."
