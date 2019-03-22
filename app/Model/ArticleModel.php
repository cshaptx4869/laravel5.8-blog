<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleModel extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['delete_at'];
    protected $table = 'article';
    protected $dateFormat = 'U';
    // 允许修改的字段
    protected $fillable = [
        'title', 'content', 'author', 'publish', 'stick', 'highlight', 'hits', 'link'
    ];
}
