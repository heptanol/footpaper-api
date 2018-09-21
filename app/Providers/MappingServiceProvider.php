<?php

namespace App\Providers;

use App\AppService;
use App\Mapping;
use Illuminate\Support\ServiceProvider;

class MappingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Mapping::class, function ($app) {
            return new Mapping();
        });
    }
}
