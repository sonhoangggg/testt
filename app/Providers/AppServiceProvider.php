<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Account;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        View::composer('admin.*', function ($view) {
            $adminId = session('admin_id');
            $admin = null;

            if (!empty($adminId)) {
                $admin = Account::find($adminId);
            }

            $view->with('admin', $admin);
        });
        // View::composer('client.layouts.header-2', function ($view) {
        //     $cart = session()->get('cart', []);
        //     $cartCount = 0;

        //     foreach ($cart as $item) {
        //         $cartCount += $item['quantity'];
        //     }

        //     $view->with('cartCount', $cartCount);
        // });
    }
}
