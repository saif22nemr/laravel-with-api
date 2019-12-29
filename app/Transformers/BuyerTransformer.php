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
}
