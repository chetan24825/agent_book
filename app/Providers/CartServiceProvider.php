<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
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
        view()->composer('*', function ($view) {
            $cart = session()->get('cart', []);

            $cartCount = count($cart);


            $view->with('globalCart', $cart)
                ->with('globalCartCount', $cartCount);
        });
    }
}
