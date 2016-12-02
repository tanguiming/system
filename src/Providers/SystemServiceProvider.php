<?php

namespace Weitac\System\Providers;

use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->router->group(['namespace' => 'Weitac\System\Controllers'], function($router) {
            require __DIR__ . '/../routes.php';
        });

        $this->loadViewsFrom(realpath(__DIR__ . '/../Views'), 'system');

        $this->publishes([
            __DIR__ . '/../../assets' => base_path('resources/assets/system'),
                ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
