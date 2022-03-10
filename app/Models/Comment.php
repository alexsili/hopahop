<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use  SoftDeletes;

    protected $table = 'comments';

    protected $fillable = array('*');

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function authors()
    {
        return $this->hasMany(User::class)->orderBy('id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
