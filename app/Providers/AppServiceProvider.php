<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * **/

    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }

        $this->app->singleton('mailer', function ($app){
            $app->configure('services');
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');

        });
    }

}