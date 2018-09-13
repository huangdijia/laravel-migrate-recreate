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
        // $this->app->singleton('migrate.foo', function () {
        //     return new FooService;
        // });
        $this->commands([
            Commands\RecreateCommand::class
        ]);
    }

    public function provides()
    {
        return [
            // 'migrate.foo'
        ];
    }
}
