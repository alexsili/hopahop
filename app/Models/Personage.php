<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personage extends Model
{
    use  SoftDeletes;

    protected $table = 'personages';

    protected $fillable = array('*');

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment');
    }

}
