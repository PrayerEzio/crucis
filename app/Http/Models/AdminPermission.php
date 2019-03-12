<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Permission;

abstract class AdminPermission extends Model implements Permission
{
    protected $table = 'permissions';

    public $guarded = [];

    protected $guard_name = 'web';

}
