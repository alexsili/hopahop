<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionReviewer extends Model
{
    protected $table = 'submission_reviewers';

    protected $fillable = array('*');


    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public static function statusUnconfirmed($submissionId)
    {
        return SubmissionReviewer::where('submission_id', $submissionId)
            ->where('status', 0)
            ->count();
    }

    public static function statusConfirmed($submissionId)
    {
        return SubmissionReviewer::where('submission_id', $submissionId)
            ->where('status', 1)
            ->count();
    }

    public static function statusRejected($submissionId)
    {
        return SubmissionReviewer::where('submission_id', $submissionId)
            ->where('status', 2)
            ->count();
    }

}
