<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = array('*');


    public function article()
    {
        return $this->belongsTo(Article::class);
    }

}
