<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/laravel-migrate-recreate.
 *
 * @link     https://github.com/huangdijia/laravel-migrate-recreate
 * @document https://github.com/huangdijia/laravel-migrate-recreate/blob/2.x/README.md
 * @contact  huangdijia@gmail.com
 */
use Huangdijia\PhpCsFixer\Config;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setHeaderComment(
        projectName: 'huangdijia/laravel-migrate-recreate',
        projectLink: 'https://github.com/huangdijia/laravel-migrate-recreate',
        projectDocument: 'https://github.com/huangdijia/laravel-migrate-recreate/blob/2.x/README.md',
        contacts: [
            'huangdijia@gmail.com',
        ],
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
            ->append([
                __FILE__,
            ])
    )
    ->setUsingCache(false);
