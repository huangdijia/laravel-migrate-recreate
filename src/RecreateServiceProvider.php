<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/laravel-migrate-recreate.
 *
 * @link     https://github.com/huangdijia/laravel-migrate-recreate
 * @document https://github.com/huangdijia/laravel-migrate-recreate/blob/2.x/README.md
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Migrate;

use Illuminate\Support\ServiceProvider;

class RecreateServiceProvider extends ServiceProvider
{
    // protected $defer    = true;

    public function boot()
    {
    }

    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\RecreateCommand::class,
                Commands\RecreateAllCommand::class,
            ]);
        }
    }
}
