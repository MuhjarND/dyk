<?php

namespace App\Providers;

use App\ProfilePage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $pages = collect();

            if (Schema::hasTable('profile_pages')) {
                $pages = ProfilePage::active()
                    ->orderBy('sort_order')
                    ->orderBy('title')
                    ->get();
            }

            $view->with('navProfilePages', $pages);
        });
    }
}
