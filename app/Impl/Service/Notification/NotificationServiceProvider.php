<?php namespace Impl\Service\Notification;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app['notification.sms'] = $app->share(function() use ($app)
        {
            return new SmsNotifier( $app['laratwilio'] )
        });
    }

}