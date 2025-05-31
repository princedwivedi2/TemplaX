<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register services here if needed
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Optimize default string length for DB
        Schema::defaultStringLength(191);

        // Optimize memory usage for large queries
        $this->app['db']->connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
    }
}
