<?php

namespace App\Transformers;
use App\Http\Models\User;
use League\Fractal\TransformerAbstract;
class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'user_sn' => $user->user_sn,
            'nickname' => $user->nickname,
            'gender' => $user->gender,
            'avatar' => $user->avatar,
            'email' => $user->email,
            'phone' => $user->phone,
            'balance' => $user->balance,
            'point' => $user->point,
            'access_source' => $user->access_source,
            'created_at' => $user->created_at->diffForHumans(),
            'deleted_at' => $user->deleted_at,
        ];
    }
} 
