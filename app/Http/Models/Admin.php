<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasRoles;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guard_name = 'web';

    protected $table = 'admins';

    protected $fillable = ['nickname', 'email', 'password', 'register_ip', 'status'];

}
