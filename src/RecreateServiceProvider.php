<?php

namespace Huangdijia\Migrate;

use Illuminate\Support\ServiceProvider;

class RecreateServiceProvider extends ServiceProvider
{
    protected $defer    = true;
    protected $commands = [
        \Huangdijia\Migrate\Commands\RecreateCommand::class,
    ];

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('migrate.foo', function () {
            return new FooService;
        });
        $this->commands($this->commands);
    }

    public function provides()
    {
        return [
            'migrate.foo'
        ];
    }
}
