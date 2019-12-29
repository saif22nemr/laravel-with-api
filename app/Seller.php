<?php

namespace App;

use App\Product;
use App\Transformers\SellerTransformer;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\addGlobalScope;
use Illuminate\Database\Eloquent\Model;
class Seller extends User
{
    //
    public $transformer = SellerTransformer::class;
    protected $table = 'users';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('products', function (Builder $builder) {
            $builder->has('products');
        });
    }
    public function products(){
      return $this->hasMany(Product::class);
    }
}
