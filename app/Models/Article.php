<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
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
