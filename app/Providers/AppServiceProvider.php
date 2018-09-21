<?php

namespace App\Providers;

use App\AppService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AppService::class, function ($app) {
            return new AppService();
        });
    }
}
