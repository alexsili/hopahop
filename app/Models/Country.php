<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public static $names = [];

    protected $fillable = ['phone', 'code', 'name'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function submissionAuthor()
    {
        return $this->hasMany(SubmissionAuthor::class);
    }

    /**
     * @return void
     * @author Alex Sili
     */
    //public static function setNames()
    //{
    //    self::$names = [];
    //
    //    $models = Country::select('id', 'name')->get();
    //    foreach ($models as $model) {
    //        self::$names[$model->id] = $model->name;
    //    }
    //}
}
