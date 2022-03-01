<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use  SoftDeletes;

    protected $table = 'articles';

    protected $fillable = array('*');

    protected $dates = ['completed_at', 'created_at', 'updated_at', 'deleted_at'];


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }


    public function authors()
    {
        return $this->hasMany(SubmissionAuthor::class)->orderBy('id');
    }

}
