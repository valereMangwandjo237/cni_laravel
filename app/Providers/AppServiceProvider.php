<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Immatriculation;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Carbon::setLocale('fr');

        View::composer('*', function ($view) {
            $valides = Immatriculation::where('status', 0)->count();
            $bloques = Immatriculation::where('status', 1)->count();
            $verifies = Immatriculation::where('status', 2)->count();
            $totals = Immatriculation::count();

            $view->with(compact('valides', 'bloques', 'verifies', 'totals'));
        });
    }
}
