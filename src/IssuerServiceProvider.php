<?php

namespace iMemento\JWT;

use Auth;
use Illuminate\Support\ServiceProvider;

class IssuerServiceProvider extends ServiceProvider
{

    /**
     * Laravel only! - ignore if not using Laravel.
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('issuer', function ($app) {

            $session_id = Auth::user()->session_id ?? null;

            $private_key = openssl_get_privatekey(file_get_contents(config('keys.private')));

            return new Issuer(config('app.name'), $private_key, $session_id);

        });
    }

    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../resources/config/keys.php');

        $this->publishes([$source => config_path('keys.php')], 'config');

        $this->mergeConfigFrom($source, 'keys');
    }

}