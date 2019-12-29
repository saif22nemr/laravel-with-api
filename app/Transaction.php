<?php

namespace App;

use App\Buyer;
use App\Product;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    //
    protected $fillable=  [
      'quantity',
      'product_id',
      'buyer_id'
    ];
    public $transformer = TransactionTransformer::class;
    public function buyers(){
      return $this->belongsTo(Buyer::class,'buyer_id');
    }
    public function products(){
      return $this->belongsTo(Product::class,'product_id');
    }
}
