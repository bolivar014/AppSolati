<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Book;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton('App\Models\Book', function ($app) {
            return new Book();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
