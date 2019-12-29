<?php

namespace App;

use App\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    //
    protected $fillable = [
      'name',
      'description'
    ];
    protected $hidden = [
    	'pivot'
    ];
    public $transformer = CategoryTransformer::class;
    public function products(){
      return $this->belongsToMany(Product::class);
    }
}
