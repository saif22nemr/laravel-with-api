<?php

namespace App;

use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    //
    protected $table = 'category_product';
    protected $fillable = [
    	'product_id',
    	'category_id'
    ];
    public function categories(){
    	return $this->belongsTo(Category::class,'category_id');
    }
    public function products(){
    	return $this->belongsTo(Product::class,'product_id');
    }
}
