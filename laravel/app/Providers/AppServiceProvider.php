<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'App\Contracts\Sms\Smser',
            'App\Library\Smser\Smser'
        );

        $this->app->singleton(
            'App\Contracts\Token\ApiToken',
            'App\Library\Token\ApiToken'
        );
    }
}
