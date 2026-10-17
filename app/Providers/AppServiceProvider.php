<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Pagination\Paginator;
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
        // Template memakai Bootstrap 3
        Paginator::useBootstrapThree();

        // Daftar genre hanya diambil saat navbar dirender
        // (tidak lagi query ke DB setiap kali aplikasi boot, jadi artisan tidak error sebelum migrate)
        View::composer('templates.component.navbar', function ($view) {
            $view->with('genres', Genre::orderBy('name')->get());
        });
    }
}
