<?php namespace Impl\Service\Notification;

use Services_Twilio;
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
            $config = $app['config'];

            $twilio = new Services_Twilio(
                $config->get('twilio.account_id'),
                $config->get('twilio.auth_token')
            );

            $notifier = SmsNotifier( $twilio );

            $notifier->from( $config['twilio.from'] )
                    ->to( $config['twilio.to'] );

            return $notifier;
        });
    }

}