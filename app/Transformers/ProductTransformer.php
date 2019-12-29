<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'prodId'=> (int)$product->id,
            'name'=>(string)$product->name,
            'details'=>(string)$product->description,
            'stock'=>(int)$product->quantity,
            'situation'=>(string)$product->status,
            'picture'=>url('img/'.$product->image),
            'seller'=>(int)$product->seller_id,
            'creationDate'=>$product->created_at,
            'lastUpdate'=>$product->update_at,
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            'prodId'=>'id',
            'stock'=>'quantity',
            'name'=>'name',
            'details'=>'description',
            'seller'=>'seller_id',
            'picture'=>'image',
            'situation'=>'status',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }
}
