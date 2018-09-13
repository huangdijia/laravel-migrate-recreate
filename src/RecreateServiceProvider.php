<?php

namespace Huangdijia\Migrate;

use Illuminate\Support\ServiceProvider;

class RecreateServiceProvider extends ServiceProvider
{
    protected $defer    = true;
    protected $commands = [
        Commands\RecreateCommand::class,
    ];

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->commands($this->commands);
    }

    public function provides()
    {
        return [];
    }
}
