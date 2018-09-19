<?php

namespace Huangdijia\Migrate;

use Illuminate\Support\ServiceProvider;

class RecreateServiceProvider extends ServiceProvider
{
    // protected $defer    = true;

    public function boot()
    {
        //
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
