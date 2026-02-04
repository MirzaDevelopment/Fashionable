<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            if (app()->runningUnitTests() && ! app()->environment('testing')) {
        throw new \RuntimeException(
            '❌ Tests are NOT running in the testing environment!'
        );
    }
    }
}
