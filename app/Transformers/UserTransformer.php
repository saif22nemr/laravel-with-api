<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            //
            'userId' => (int)$user->id,
            'name' => (string)$user->name,
            'email'=>(string)$user->email,
            'isVerified'=>(int)$user->verified,
            'isAdmin'=>($user->admin === 'true'),
            'creationDate'=>$user->created_at,
            'lastUpdate'=>$user->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('users.show',$user->id)
                ],
            ],
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            //
            'userId' => 'id',
            'name' => 'name',
            'email'=>'email',
            'isVerified'=>'verified',
            'isAdmin'=>'admin',
            'creationDate'=>'created_at',
            'lastUpdate'=>'updated_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
