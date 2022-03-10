<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use  SoftDeletes;

    protected $table = 'shop';

    protected $fillable = array('*');

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


}
