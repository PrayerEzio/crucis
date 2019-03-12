<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Role;

abstract class AdminRole extends Model implements Role
{
    protected $table = 'roles';

    public $guarded = [];

    protected $guard_name = 'web';
}
