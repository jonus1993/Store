<?php

namespace App\Providers;

use View;
use App\Cart2;
use App\Cart_Items;
use App\Tags;
use App\Categories;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //add configuration
        View::composer('partials.header', function ($view) {
            $cart = Cart2::where('user_id', Auth::id())->first();
            $count = 0;
            if ($cart != null) {
                $count = Cart_Items::where('cart_id', $cart->id)->sum('qty');
            }
            $view->with('cartQty', $count);
        });

//        View::composer('items.add2', function ($view) {
//            $tags = Tags::all();
//            $categories = Categories::all();
//
//            $view->with('categories', $categories)->with('tags', $tags);
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
