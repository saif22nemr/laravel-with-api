<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'buyerId' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email'=>(string)$buyer->email,
            'isVerified'=>(int)$buyer->verified,
            'creationDate'=>$buyer->created_at,
            'lastUpdate'=>$buyer->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('buyers.show',$buyer->id),
                ],
                [
                    'rel' => 'buyers.products',
                    'href'=> route('buyers.products.index',$buyer->id),
                ],
                [
                    'rel' => 'buyers.categories',
                    'href'=> route('buyers.categories.index',$buyer->id),
                ],
                [
                    'rel' => 'buyers.sellers',
                    'href'=> route('buyers.sellers.index',$buyer->id),
                ],
                [
                    'rel' => 'buyers.transactions',
                    'href'=> route('buyers.transactions.index',$buyer->id),
                ],
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes =  [
            'buyerId' => 'id',
            'name' => 'name',
            'email'=>'email',
            'isVerified'=>'verified',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
        ];
        return isset($attributes[$index])?$attributes[$index] : null;
    }
    public static function transformedAttribute($index){
        $attributes =  [
            'id'=>'buyerId',
            'name'=>'name',
            'email'=>'email',
            'verified'=>'isVerified',
            'created_at'=>'creationDate',
            'updated_at'=>'lastUpdate',
        ];
        return isset($attributes[$index])?$attributes[$index] : null;
    }
}
