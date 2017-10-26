<?php

namespace iMemento\JWT;

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
        //issuer api
        if(config('keys.issuer_api')) {
            $this->app->singleton('issuer-api', function ($app) {
                $private_key = openssl_get_privatekey(file_get_contents(config('keys.private_api')));

                //the token store class from config
                $class = '\\'.ltrim(config('jwt.token_store'), '\\');
                $token_store = new $class;

                return new Issuer(config('keys.issuer_api'), $private_key, $token_store);
            });
        }

        //issuer web
        if(config('keys.issuer_web')) {
            $this->app->singleton('issuer-web', function ($app) {
                $private_key = openssl_get_privatekey(file_get_contents(config('keys.private_web')));

                //the token store class from config
                $class = '\\'.ltrim(config('jwt.token_store'), '\\');
                $token_store = new $class;

                return new Issuer(config('keys.issuer_web'), $private_key, $token_store);
            });
        }
    }

    protected function setupConfig()
    {
        $jwt = realpath(__DIR__.'/../resources/config/jwt.php');
        $keys = realpath(__DIR__.'/../resources/config/keys.php');

        $this->publishes([
            $jwt => config_path('jwt.php'),
            $keys => config_path('keys.php'),
        ], 'config');

        $this->mergeConfigFrom($jwt, 'jwt');
        $this->mergeConfigFrom($keys, 'keys');
    }

}