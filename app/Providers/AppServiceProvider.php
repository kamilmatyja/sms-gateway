<?php

namespace App\Providers;

use App\Contracts\SmsProviderInterface;
use App\Services\Providers\SmsApiProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    final public function register(): void
    {
        $this->app->bind(
            SmsProviderInterface::class,
            SmsApiProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    final public function boot(): void
    {
        //
    }
}
