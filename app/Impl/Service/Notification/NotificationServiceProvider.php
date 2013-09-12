<?php namespace Impl\Service\Notification;

use Services_Twilio;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app['impl.notifier'] = $app->share(function() use ($app)
        {
            $config = $app['config'];

            $twilio = new Services_Twilio(
                $config->get('twilio.account_id'),
                $config->get('twilio.auth_token')
            );

            $notifier = new SmsNotifier( $twilio );

            $notifier->from( $config['twilio.from'] )
                    ->to( $config['twilio.to'] );

            return $notifier;
        });
    }

    public function provides()
    {
        return array('impl.notifier');
    }

}