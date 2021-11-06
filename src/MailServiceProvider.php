<?php

namespace BristolSU\Mail;

use Aws\Sdk;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider implements DeferrableProvider
{

    const VERSION = '3.6.0';

    public function register()
    {
        $this->registerConfig();
        $this->registerMigrations();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerAssets();
        $this->registerAws();
    }

    public function registerAws()
    {
        $this->app->singleton('aws', function ($app) {
            return new Sdk(
                $app->make('config')->get('portal_mail.aws')
            );
        });
        $this->app->alias('aws', 'Aws\Sdk');
    }

    public function registerConfig()
    {
        $this->publishes([__DIR__ . '/../config/portal_mail.php' => config_path('portal_mail.php')], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../config/portal_mail.php', 'portal_mail');
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'portal-mail');
    }

    public function registerAssets()
    {
        $this->publishes([
            __DIR__ . '/..//public/modules/portal-mail' => public_path('modules/portal-mail')
        ], ['module', 'module-assets', 'assets']);
    }

    public function registerRoutes()
    {
        Route::middleware(['portal-auth'])
            ->group(function() {
                Route::middleware(['web'])->prefix('mail')->group(__DIR__ . '/../routes/web.php');
                Route::middleware(['api'])->prefix('api/mail')->group(__DIR__ . '/../routes/api.php');
            });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aws', 'Aws\Sdk'];
    }
}
