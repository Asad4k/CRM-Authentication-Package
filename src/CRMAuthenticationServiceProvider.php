<?php

namespace AJG\CRM_Authentication;

use Illuminate\Support\ServiceProvider;

class CRMAuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
        $this->app->make('AJG\CRM_Authentication\CRMAuthenticationController');
        $this->loadViewsFrom(__DIR__.'/views', 'crm_authentication');
        $this->publishes([
            __DIR__ . '/config' => config_path('crm_authentication')
        ], 'config');
        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
        $this->app['router']->aliasMiddleware('crm_authentication' , \AJG\CRM_Authentication\Middleware\CRMAuthCheck::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }
}
