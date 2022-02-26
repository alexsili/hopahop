<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'code', 'name'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
