<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\WhiteList;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories_global', \App\Models\Category::where('parent_id', 0)->with('children')->get());
        });

        View::composer('*', function ($view) {
            $view->with('cart_global', Cart::getCart(auth()->id()));
        });

        View::composer('*', function ($view) {
            $view->with('count_whitelist_global', WhiteList::where('user_id', auth()->id())->count());
        });
    }
}
