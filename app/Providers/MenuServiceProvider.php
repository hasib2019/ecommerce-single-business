<?php

namespace App\Providers;

use App\Services\Menu\Menu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('menu', function ($app) {
            return new Menu();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../../config/menu.php' => config_path('menu.php'),
        ], 'config');
    }
}