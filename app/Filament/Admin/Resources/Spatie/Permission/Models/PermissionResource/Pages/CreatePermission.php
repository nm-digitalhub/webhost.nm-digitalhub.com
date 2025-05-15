<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Spatie\Permission\Models\PermissionResource\Pages;

use App\Filament\Admin\Resources\Spatie\Permission\Models\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
}
