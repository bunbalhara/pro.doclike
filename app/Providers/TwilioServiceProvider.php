<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use App\Broadcasters\SyncBroadcaster;
use Twilio\Rest\Client as TwilioClient;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sync', function ($app) {
            $client = new TwilioClient(
                $app['config']->get('broadcasting.connections.sync.accountSid'),
                $app['config']->get('broadcasting.connections.sync.authToken'));
            return $client->sync->services(
                $app['config']->get('broadcasting.connections.sync.serviceSid')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::extend('sync',function ($app) {
            return new SyncBroadcaster($app->make('sync'));
        });
    }
}
