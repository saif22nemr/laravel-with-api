<?php

namespace App;

use App\Scope\BuyerScope;
use App\Transaction;
use App\Transformers\BuyerTransformer;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\addGlobalScope;
use Illuminate\Database\Eloquent\Model;
class Buyer extends User
{
    //
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new BuyerScope);
    // }
    public $transformer = BuyerTransformer::class;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('transactions', function (Builder $builder) {
            $builder->has('transactions');
        });
    }
    public function transactions(){
      return $this->hasMany(Transaction::class);
    }
    public function testBuyer(){
    	return $this->transactions;
    }
}
