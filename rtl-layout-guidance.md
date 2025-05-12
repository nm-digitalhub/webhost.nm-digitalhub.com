# RTL Support in Filament 3 with Laravel 12

## Overview

In Filament 3, the way to implement RTL (Right-to-Left) support has been updated. The `rtl()` method is no longer available and has been replaced with a more flexible `direction()` method.

## Changes Made

In the AdminPanelProvider, we've replaced:
