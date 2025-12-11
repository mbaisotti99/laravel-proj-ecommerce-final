<?php

namespace App\Providers;

use App\Categorie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.master', function ($cats) {
            $cats->with('cats', Categorie::cases());
        });

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
