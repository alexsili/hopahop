<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    protected $table = 'submission_files';

    protected $fillable = array('*');

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

}
