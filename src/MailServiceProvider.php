<?php

namespace BristolSU\Mail;

use Aws\Sdk;
use BristolSU\Mail\Actions\SendEmail;
use BristolSU\Mail\Capture\Contracts\IsRecorded;
use BristolSU\Mail\Capture\Events\MessageFailed;
use BristolSU\Mail\Capture\Listeners\MailFailedListener;
use BristolSU\Mail\Capture\Listeners\MailSendingListener;
use BristolSU\Mail\Capture\Listeners\MailSentListener;
use BristolSU\Mail\Capture\MailManager;
use BristolSU\Mail\Ses\DisabledClient;
use BristolSU\Mail\Ses\SesClient;
use BristolSU\Mail\Ses\SesSdkClient;
use BristolSU\Support\Action\Facade\ActionManager;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MailServiceProvider extends ServiceProvider
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
        $this->registerEmailCapture();
        $this->registerCommands();
    }

    public function boot()
    {
        $this->registerAction();
    }

    public function registerAction()
    {
        ActionManager::registerAction(SendEmail::class, 'Send an Email', 'Send an email directly to the portal to email addresses');
    }

    public function registerEmailCapture()
    {
        $this->app['events']->listen(MessageSending::class, MailSendingListener::class);
        $this->app['events']->listen(MessageSent::class, MailSentListener::class);
        $this->app['events']->listen(MessageFailed::class, MailFailedListener::class);

        $this->app->extend('mail.manager', function(Factory $mailer, $app) {
            return $app->make(MailManager::class, ['mailer' => $mailer]);
        });

        $existingCallback = Mailable::$viewDataCallback;

        Mailable::buildViewDataUsing(function (Mailable $mailable) use ( $existingCallback ) {
            $existingData = $existingCallback ? call_user_func( $existingCallback, $mailable ) : [];

            return array_merge(
                is_array($existingData) ? $existingData : [],
                $mailable instanceof IsRecorded ? [
                    '__bristol_su_mail_to' => $mailable->payload()->getTo(),
                    '__bristol_su_mail_cc' => $mailable->payload()->getCc(),
                    '__bristol_su_mail_bcc' => $mailable->payload()->getBcc(),
                    '__bristol_su_mail_content' => $mailable->payload()->getContent(),
                    '__bristol_su_mail_subject' => $mailable->payload()->getSubject(),
                    '__bristol_su_mail_from_id' => $mailable->payload()->getFrom()->id,
                    '__bristol_su_mail_notes' => $mailable->payload()->getNotes(),
                    '__bristol_su_mail_sent_via' => $mailable->payload()->getSentVia()
                ] : [],
                [
                    '__bristol_su_mail_uuid' => Str::uuid(),
                    '__bristol_su_mail_user_id' => app(Authentication::class)->hasUser() ? app(Authentication::class)->getUser()->id() : null,
                ]
            );
        });

    }

    public function registerCommands()
    {
        $this->commands([
            \BristolSU\Mail\Commands\SyncEmailAddressesCommand::class
        ]);
    }

    public function registerAws()
    {
        $this->app->singleton('portal-mail-aws', function ($app) {
            return new Sdk(
                $app->make('config')->get('portal_mail.aws')
            );
        });

        $this->app->singleton(SesClient::class, function($app) {
            if($app->make('config')->get('portal_mail.enable_aws', true)) {
                return $app->make(SesSdkClient::class);
            }
            return $app->make(DisabledClient::class);
        });
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

}
