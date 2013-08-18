<?php namespace Impl\Exception;

use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $app = $this->app;

        $app['impl.exception'] = $app->share(function() use ($app)
        {
            return new Handler( $app['notification.sms'] );
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $app->error(function(ImplException $e) use ($app)
        {
            $app['impl.exception']->handle($e);
        });
    }
}