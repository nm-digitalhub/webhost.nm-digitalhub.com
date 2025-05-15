<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailSettingResource\Pages;

use App\Filament\Resources\MailSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMailSetting extends CreateRecord
{
    protected static string $resource = MailSettingResource::class;
}
