<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->cacheDirectory(__DIR__.'/var/rector');
    $rectorConfig->paths([
        __DIR__.'/bin/console',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/src',
    ]);
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84,
    ]);
};
