<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/database',
        __DIR__ . '/resources/views',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::PRIVATIZATION,
        SetList::DEAD_CODE,
    ]);
};
