<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FilamentInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.filament-info-widget';

    // Full width for better display
    protected int|string|array $columnSpan = 'full';
}
