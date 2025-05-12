# Resource Namespace Migration Plan

## Overview

During the AdminPanelProvider review, we identified that some Filament resources are still referenced using outdated namespace patterns. This document outlines the plan to migrate all resources to their correct namespaces according to Laravel 12 and Filament 3 standards.

## Current Issues

1. Some resources are referenced with the `\App\Filament\Admin\Resources\` namespace prefix (legacy structure)
2. Resources should be consolidated under the standard `\App\Filament\Resources\` namespace

## Migration Steps

### 1. Move Resource Classes

For each resource currently in `app/Filament/Admin/Resources/`, move it to `app/Filament/Resources/`:
