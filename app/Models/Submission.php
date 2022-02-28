<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Submission extends Model
{
    protected $table = 'submissions';

    protected $fillable = array('*');

    protected $dates = ['completed_at', 'created_at', 'updated_at', 'deleted_at', 'initiated_date', 'due_date', 'uploaded_file_date', 'editor_decision_date'];

    public function files()
    {
        return $this->hasMany(SubmissionFile::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'desc');
    }

    public function authors()
    {
        return $this->hasMany(SubmissionAuthor::class)->orderBy('id');
    }

    public function getRevisions()
    {
        return Submission::where('parent_id', $this->id)->get();
    }

    public function authorsList()
    {
        $authorsList = [];
        $authors = $this->authors;
        foreach ($authors as $author) {
            $authorsList[] = $author->first_name . ' ' . $author->last_name;
        }
        $authorsList = implode(', ', $authorsList);

        return $authorsList;
    }

    public function decision()
    {

        $decision = SubmissionReviewer::where('submission_id', $this->id)->where('reviewer_id', Auth::user()->id)->first();

        if ($decision == null) {
            return false;
        }

        return $decision->status;
    }

    public function hasMessages()
    {
        $messagesCount = ChatMessage::where('submission_id', $this->id)
            ->where('viewed', 0)
            ->count();

        return $messagesCount > 0 ? true : false;
    }
}
