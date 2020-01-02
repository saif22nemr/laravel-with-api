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
            'title'=>(string)$product->name,
            'details'=>(string)$product->description,
            'stock'=>(int)$product->quantity,
            'situation'=>(string)$product->status,
            'picture'=>url('img/'.$product->image),
            'seller'=>(int)$product->seller_id,
            'creationDate'=>$product->created_at,
            'lastUpdate'=>$product->update_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('products.show',$product->id)
                ],
                [
                    'rel' => 'products.buyers',
                    'href'=> route('products.buyers.index',$product->id)
                ],
                [
                    'rel' => 'products.categories',
                    'href'=> route('products.categories.index',$product->id)
                ],
                [
                    'rel' => 'products.transactions',
                    'href'=> route('products.transactions.index',$product->id)
                ],
                [
                    'rel' => 'products.sellers',
                    'href'=> route('products.sellers.show',[$product->id,$product->seller_id])
                ],
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            'prodId'=>'id',
            'stock'=>'quantity',
            'title'=>'name',
            'details'=>'description',
            'seller'=>'seller_id',
            'picture'=>'image',
            'situation'=>'status',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }
    public static function transformedAttribute($index){
        $attributes = [
            'id'=>'prodId',
            'quantity'=>'stock',
            'name'=>'title',
            'description'=>'details',
            'seller_id'=>'seller',
            'image'=>'picture',
            'status'=>'situation',
            'created_at'=>'creationDate',
            'updated_at'=>'lastUpdate',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }
}
