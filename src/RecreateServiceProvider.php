<?php

namespace Huangdijia\Migrate;

use Illuminate\Support\ServiceProvider;

class RecreateServiceProvider extends ServiceProvider
{
    protected $defer    = true;

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(Commands\RecreateCommand::class, function () {
            return new Commands\RecreateCommand; // 这是一段废话
        });
        $this->commands([
            Commands\RecreateCommand::class
        ]);
    }

    public function provides()
    {
        return [
            Commands\RecreateCommand::class
        ];
    }
}
