<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubmissionAuthor extends Model
{
    protected $table = 'submission_authors';

    protected $fillable = array('*');

    /**
     * Get the country record associated with the user.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get user full name
     * @return string
     */
    public function getFullNameAttribute() // usage: $submissionAuthor->full_name
    {
        return trim($this->first_name) . ' ' . trim($this->last_name);
    }

}
