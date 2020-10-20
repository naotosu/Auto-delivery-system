<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TemporaryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'TemporaryService',
            'App\Services\TemporaryService'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
