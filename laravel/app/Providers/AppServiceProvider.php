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
            'App\Contracts\Push\Pusher',
            'App\Library\Pusher\LeanCloud'
        );

        $this->app->singleton(
            'App\Contracts\Sms\Smser',
            'App\Library\Smser\Smser'
        );

        $this->app->singleton(
            'App\Contracts\Token\AuthToken',
            'App\Library\Token\AuthToken'
        );

        $this->app->singleton(
            'qiniu', 'App\Library\Qiniu\Qiniu'
        );
    }
}
