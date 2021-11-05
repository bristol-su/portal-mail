<?php

namespace BristolSU\Mail;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerConfig();
        $this->registerMigrations();
        $this->registerViews();
        $this->registerRoutes();
    }

    public function registerConfig()
    {
//        $this->publishes([__DIR__ . '/../config/config.php' => config_path('support.php')], 'config');
//        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'support');
    }

    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function registerViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bristolsu'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bristolsu');
    }

    public function registerRoutes()
    {
        Route::middleware(['web', 'portal-auth'])
            ->group(__DIR__ . '/../routes/web.php');

        Route::middleware(['api', 'portal-auth'])
            ->group(__DIR__ . '/../routes/api.php');
    }
}
