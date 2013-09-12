<?php namespace Impl\Exception;

use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{

    public function register()
    {
        $app = $this->app;

        $app['impl.exception'] = $app->share(function($app)
        {
            return new NotifyHandler( $app['impl.notifier'] );
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