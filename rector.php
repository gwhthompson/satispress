<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
        // __DIR__.'/tests',
        __DIR__.'/views',
        __DIR__.'/satispress.php',
    ]);

    // $rectorConfig->autoloadPaths([
    //     __DIR__.'/vendor/szepeviktor/phpstan-wordpress',
    //     __DIR__.'/vendor/php-stubs/wordpress-stubs/wordpress-stubs.php',
    // ]);

    $rectorConfig->bootstrapFiles([
        __DIR__.'/vendor/szepeviktor/phpstan-wordpress/bootstrap.php',
        __DIR__.'/vendor/php-stubs/wordpress-stubs/wordpress-stubs.php',
    ]);

    // // register a single rule
    // $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        // LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
    ]);
};
