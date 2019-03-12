<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'article_category';

    protected $fillable = ['name', 'parent_id', 'sort', 'status'];

    public function articles()
    {
        return $this->hasMany('App\Http\Models\Article','category_id','id');
    }
}
