<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
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
       View::composer('*', function ($view) {
           if(Auth::check()){
               $bookingsStatus = Booking::where('user_id', Auth::id())
                   ->where('status', 'Pending')
                   ->count();
               $view->with('bookingsStatus', $bookingsStatus);
           }
        });
    }
}
