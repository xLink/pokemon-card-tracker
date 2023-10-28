<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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

        Collection::macro('paginate', function ($perPage = 15, $page = null, $options = []) {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
            return (new LengthAwarePaginator(
                $this->forPage($page, $perPage), 
                $this->count(), 
                $perPage, 
                $page, 
                $options
            ))
                ->withPath('');
        });

    }
}
