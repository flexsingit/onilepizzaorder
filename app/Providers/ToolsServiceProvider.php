<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ToolsServiceProvider extends ServiceProvider
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
        \Illuminate\Support\Facades\App::bind('tools', function() {
            return new \App\FacadeHelpers\Tools;
        });
        
        \Illuminate\Support\Facades\App::bind('checkout', function() {
            return new \App\FacadeHelpers\Checkout;
        });
    }
}
