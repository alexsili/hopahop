<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use  SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = array('*');

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

}