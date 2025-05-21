<?php

namespace Matscode\PaystackLaravel;

use Illuminate\Support\ServiceProvider;
use Matscode\Paystack\Paystack;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/paystack.php' => config_path('paystack.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/paystack.php', 'paystack'
        );

        $this->app->singleton(Paystack::class, function ($app) {
            $config = $app['config']['paystack'];
            return new Paystack($config['secret_key']);
        });

        $this->app->alias(Paystack::class, 'paystack');
    }
} 