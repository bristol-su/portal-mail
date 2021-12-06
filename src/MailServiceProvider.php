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
use BristolSU\Mail\Mail\Upload\UploadAttachments;
use BristolSU\Mail\Mail\Upload\Uploaders\Base64;
use BristolSU\Mail\Mail\Upload\Uploaders\RemoteFile;
use BristolSU\Mail\Mail\Upload\Uploaders\UploadedFile;
use BristolSU\Mail\Models\Attachment;
use BristolSU\Mail\Models\EmailAddressUser;
use BristolSU\Mail\Ses\DisabledClient;
use BristolSU\Mail\Ses\SesClient;
use BristolSU\Mail\Ses\SesSdkClient;
use BristolSU\Support\Action\Facade\ActionManager;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Permissions\Facade\Permission;
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
        $this->registerUpload();
        $this->registerAction();
        $this->registerPermissions();
    }

    public function registerUpload()
    {
        UploadAttachments::useUploader(Base64::class);
        UploadAttachments::useUploader(RemoteFile::class);
        UploadAttachments::useUploader(UploadedFile::class);
    }

    public function registerPermissions()
    {
        Permission::registerSitePermission('manage-mail', 'Manage Mail', 'Can manage and control access to the emailer');
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
        $this->app['events']->listen(fn(\BristolSU\ControlDB\Events\User\UserDeleted $event) => EmailAddressUser::where('user_id', $event->user->id())->delete());

        $this->app->extend('mail.manager', function(Factory $mailer, $app) {
            return $app->make(MailManager::class, ['mailer' => $mailer]);
        });


        Mailable::buildViewDataUsing(function (Mailable $mailable) {
            $existingCallback = Mailable::$viewDataCallback;
            $existingData = $existingCallback ? call_user_func( $existingCallback, $mailable ) : [];
\Log::info('Called for payload: ' . json_encode($mailable->payload()));
            return array_merge(
                is_array($existingData) ? $existingData : [],
                $mailable instanceof IsRecorded ? ['__bristol_su_mail_payload' => $mailable->payload()] : [],
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
