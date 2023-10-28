<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
        Request::macro('isCurrentRoute', function ($routeNames) {
            $bool = false;
            foreach (is_array($routeNames) ? $routeNames : explode(",",$routeNames) as $name) {
               if(request()->routeIs($name)) {
                   $bool = true;
                   break;
                }
             }

             return $bool;
        });
    }
}
