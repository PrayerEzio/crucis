<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_log';

    protected $fillable = ['type', 'level', 'title', 'content', 'operator_type', 'operator_id', 'ip'];
}
