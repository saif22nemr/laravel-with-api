<?php

namespace App;

use App\Category;
use App\Seller;
use App\Transaction;
use App\Transformers\ProductTransformer;
use App\User;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    //
    const AvailableProduct = 'available';
    const UnavailableProduct = 'unavailable';
    protected $fillable = [
      'name',
      'description',
      'status',
      'quantity',
      'image',
      'seller_id'
    ];
    public $transformer = ProductTransformer::class;
    public function isAvailable(){
      return $this->status == Product::AvailableProduct;
    }
    //Start Relationship
    public function categories(){
      return $this->belongsToMany(Category::class);
    }
    public function sellers(){
      return $this->belongsTo(Seller::class,'seller_id');
    }
    public function transactions(){
      return $this->hasMany(Transaction::class);
    }
}
