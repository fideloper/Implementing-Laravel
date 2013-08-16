<?php namespace Impl\Service\Form;

use Illuminate\Support\ServiceProvider;
use Impl\Service\Form\Article\ArticleForm;

class FormServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind('Impl\Service\Form\Article\ArticleForm', function() use ($app)
        {
            return new ArticleForm( $app['validator'], $app->make('Impl\Repo\Article\ArticleInterface') );
        });
    }

}