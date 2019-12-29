<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        //
        Schema::defaultStringLength(191);
        User::created(function($user){
            Mail::to($user)->send(new UserCreated($user));
        });
        User::updated(function($user){
            if($user->isDirty())
                Mail::to($user)->send(new UserMailChange($user));
        });
        Product::updated(function($product){
            if($product->quantity == 0 and $product->isAvailable()){
                $product->status = Product::UnavailableProduct;
                $product->save();
            }
        });
    }
}
