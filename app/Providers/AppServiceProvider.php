<?php

namespace App\Providers;

use View;
use Illuminate\Support\Facades\Cache;
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
        $tags = Cache::get('tags', function () {
            return  $tags = Tags::all();
        });
        $categories = Cache::get('categories', function () {
            return  $categories = Categories::all();
        });
        View::share(['tags' => $tags,'categories' => $categories]);
   
        //add configuration
        View::composer('partials.header', function ($view) {
            $user = Auth::user();
            if ($user != null) {
                $cart = $user->getCart();
       
                $count = 0;
                if ($cart != null) {
                    $cart_items = $cart->items()->get();
                    foreach ($cart_items as $item) {
                        $count += $item->pivot->qty;
                    }
                }
                $view->with('cartQty', $count);
            }
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
