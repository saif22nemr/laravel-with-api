<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'tranId'=>(int)$transaction->id,
            'quatity'=>(int)$transaction->quantity,
            'buyer'=>(int)$transaction->buyer_id,
            'product'=>(int)$transaction->product_id,
            'creationDate'=>$transaction->created_at,
            'lastUpdate'=>$transaction->updated_at,
            'deletedDate'=>isset($transation->deleted_at)?(int)$transaction->deleted_at:null,
            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('transactions.show',$transaction->id)
                ],
                [
                    'rel' => 'transactions.categories',
                    'href'=> route('transactions.categories.index',$transaction->id)
                ],
                [
                    'rel' => 'transactions.buyers',
                    'href'=> route('transactions.buyers.index',$transaction->id)
                ],
                [
                    'rel' => 'transactions.products',
                    'href'=> route('transactions.products.index',$transaction->id)
                ],
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            'tranId'=>'id',
            'quatity'=>'quantity',
            'buyer'=>'buyer_id',
            'product'=>'product_id',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
            'deletedDate'=>'deleted_at',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }
}
