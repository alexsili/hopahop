<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubmissionRevision extends Model
{
    protected $table = 'submission_revisions';

    protected $fillable = array('*');


    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

}
