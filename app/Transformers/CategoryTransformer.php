<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'catId'=>(int)$category->id,
            'name'=>(string)$category->name,
            'details'=>(string)$category->description,
            'creationDate'=>$category->created_at,
            'lastUpdate'=>$category->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('categories.show',$category->id)
                ],
                [
                    'rel' => 'categories.products',
                    'href'=> route('categories.products.index',$category->id)
                ],
                [
                    'rel' => 'categories.buyers',
                    'href'=> route('categories.buyers.index',$category->id)
                ],
                [
                    'rel' => 'categories.sellers',
                    'href'=> route('categories.sellers.index',$category->id)
                ],
                [
                    'rel' => 'categories.transactions',
                    'href'=> route('categories.transactions.index',$category->id)
                ],
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes =  [
            'catId' => 'id',
            'name' => 'name',
            'details'=>'description',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
        ];
        return isset($attributes[$index])?$attributes[$index] : null;
    }
    public static function transformedAttribute($index){
        $attributes =  [
            'id' => 'catId',
            'name' => 'name',
            'description' => 'details',
            'created_at' => 'creationDate',
            'updated_at' => 'lastUpdate',
        ];
        return isset($attributes[$index])?$attributes[$index] : null;
    }
}
