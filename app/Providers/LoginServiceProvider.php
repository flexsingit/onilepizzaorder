<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Illuminate\Support\Facades\App::bind('login', function() {
            return new \App\FacadeHelpers\Login;
        });
        
        \Illuminate\Support\Facades\App::bind('adminLogin', function() {
            return new \App\FacadeHelpers\AdminLogin;
        });
    }
}
