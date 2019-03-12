<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $table = 'user_invitations';

    public function inviter()
    {
        return $this->belongsTo('App\Http\Models\User', 'inviter_id');
    }

    public function invitee()
    {
        return $this->belongsTo('App\Http\Models\User', 'invitee_id');
    }

    public function scopeIsFinish($query)
    {
        return $query->where('stage','>',1);
    }

    public function scopeIsNotFinish($query)
    {
        return $query->where('stage','=',1);
    }
}
