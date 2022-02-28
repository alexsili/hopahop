<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Mail\SubmissionNewAuthor;
use App\Mail\SubmissionNewEditor;
use App\Models\ChatMessage;
use App\Models\Country;
use App\Models\Submission;
use App\Models\SubmissionAuthor;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $submissions = Submission::where('status', 4)
            ->where('parent_id', null)
            ->where('author_id', Auth::user()->id)
            ->get();

        return view('submission.index')
            ->with('submissions', $submissions);
    }

    public function show($id)
    {
        $submission = Submission::findOrFail($id);

        return view('submission.show')
            ->with('submission', $submission);
    }

    public function getReview($id)
    {
        $submission = Submission::where('id', $id)
            ->where('status', 4)
            ->where('author_id', Auth::user()->id)
            ->first();

        if ($submission == null) {
            return redirect('/submissions')->with('error', 'Submission not found!');
        }

        if (Auth::user()->isAuthor()) {
            if ($submission->status !== 4) {
                return redirect('/submissions')->with('error', 'Cannot access submission at this time!');
            }
        }

        $countries = Country::pluck('name', 'id');

        return view('submission.review')
            ->with('countries', $countries)
            ->with('submission', $submission);
    }

    public function create()
    {
        $countries = Country::pluck('name', 'id');

        return view('submission.create')->with('countries', $countries);
    }

    public function store(Request $request)
    {
        $rules['title'] = 'required|string|max:255';
        $rules['section'] = 'required|string|max:255';
        $rules['keywords'] = 'required|string|max:255';
        $rules['abstract'] = 'required|string|max:255';
        $rules['submission_file'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        $rules['cover_letter'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        $rules['supplementary_file.*'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';

        $rules['authors.*.first_name'] = 'required|string|max:255';
        $rules['authors.*.last_name'] = 'required|string|max:255';
        $rules['authors.*.email'] = 'required';
        $rules['authors.*.affiliation'] = 'required|string|max:255';
        $rules['authors.*.country'] = 'required|string|max:255';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('submissions/create')
                ->withErrors($validator)
                ->withInput();
        }

        $submission = new Submission();
        $submission->author_id = Auth::user()->id;
        $submission->title = $request->get('title');
        $submission->section = $request->get('section');
        $submission->keywords = $request->get('keywords');
        $submission->abstract = $request->get('abstract');
        $submission->status = 0;
        $submission->initiated_date = now();

        if ($request->hasFile('cover_letter')) {
            $extension = $request->file('cover_letter')->getClientOriginalExtension();
            $coverLetter = str_replace(' ', '', $request->title) . '_' . 'cover_letter' . '.' . $extension;
            $request->file('cover_letter')->move('uploads/coverLetters', $coverLetter);
            $submission->cover_letter = $coverLetter;
        }

        if ($request->hasFile('submission_file')) {
            $extension = $request->file('submission_file')->getClientOriginalExtension();
            $submissionFile = str_replace(' ', '', $request->title) . '_' . 'submission' . '.' . $extension;
            $request->file('submission_file')->move('uploads/submissionFiles', $submissionFile);
            $submission->file = $submissionFile;
        }
        $submission->save();

        foreach ($request->get('authors') as $author) {
            $submissionAuthor = new SubmissionAuthor();
            $submissionAuthor->submission_id = $submission->id;
            $submissionAuthor->first_name = $author['first_name'];
            $submissionAuthor->last_name = $author['last_name'];
            $submissionAuthor->email = $author['email'];
            $submissionAuthor->affiliation = $author['affiliation'];
            $submissionAuthor->country_id = $author['country'];
            $submissionAuthor->hash = md5($author['first_name'].$author['last_name'].$author['email'].$author['affiliation'].$author['country']);
            $submissionAuthor->save();
        }

        if ($request->hasFile('supplementary_file')) {
            foreach ($request->file('supplementary_file') as $file) {
                $submissionFile = new SubmissionFile();
                $submissionFile->submission_id = $submission->id;
                $extension = $file->getClientOriginalExtension();
                $supplementaryFile = str_replace(' ', '', $request->title) . '_' . 'supplementary' . '.' . $extension;
                $file->move('uploads/supplementaryFiles', $supplementaryFile);
                $submissionFile->filename = $supplementaryFile;
                $submissionFile->save();
            }
        }

        if (!empty(Helper::editorEmails())) {
            Mail::to(Helper::editorEmails())->send(new SubmissionNewEditor(Auth::user(), $submission));
        }

        Mail::to(Auth::user()->email)->send(new SubmissionNewAuthor(Auth::user(), $submission));

        return redirect('/submissions')->with('success', 'Submission created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $submission = Submission::where('id', $id)
            ->where('status', 4)
            ->where('author_id', Auth::user()->id)
            ->first();

        if ($submission == null) {
            return redirect('/submissions')->with('error', 'Submission not found!');
        }

        $countries = Country::pluck('name', 'id')->toArray();

        return view('submission.edit')
            ->with('countries', $countries)
            ->with('submission', $submission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $submission = Submission::find($id);

        $rules['title'] = 'required|string|max:255';
        $rules['section'] = 'required|string|max:255';
        $rules['keywords'] = 'required|string|max:255';
        $rules['abstract'] = 'required|string|max:255';
        $rules['supplementary_file.*'] = 'max:30000';

        $rules['authors.*.first_name'] = 'required|string|max:255';
        $rules['authors.*.last_name'] = 'required|string|max:255';
        $rules['authors.*.country'] = 'required|string|max:255';
        $rules['authors.*.affiliation'] = 'required|string|max:255';
        $rules['authors.*.email'] = 'required';

        if ($submission->file == null) {
            $rules['submission_file'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        } else {
            $rules['submission_file'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        }

        if ($submission->cover_letter == null) {
            $rules['cover_letter'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        } else {
            $rules['cover_letter'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('submissions/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }


        $submissionFile = SubmissionFile::where('submission_id', $id)->first();
        if (empty($submissionFile)) {
            $submissionFile = new SubmissionFile();
        }

        $submission->title = $request->get('title');
        $submission->section = $request->get('section');
        $submission->keywords = $request->get('keywords');
        $submission->abstract = $request->get('abstract');

        if ($request->hasFile('cover_letter')) {
            if (file_exists(public_path('uploads/coverLetters/' . $submission->cover_letter . '')) && !empty($submission->cover_letter)) {
                unlink(public_path('uploads/coverLetters/' . $submission->cover_letter . ''));
            }
            $extension = $request->file('cover_letter')->getClientOriginalExtension();
            $coverLetter = str_replace(' ', '-', $request->title) . '_' . 'cover_letter' . '.' . $extension;
            $request->file('cover_letter')->move('uploads/coverLetters', $coverLetter);
            $submission->cover_letter = $coverLetter;
        }

        if ($request->hasFile('submission_file')) {
            if (file_exists(public_path('uploads/submissionFiles/' . $submission->file . '')) && !empty($submission->file)) {
                unlink(public_path('uploads/submissionFiles/' . $submission->file . ''));
            }
            $extension = $request->file('submission_file')->getClientOriginalExtension();
            $submissionFileName = str_replace(' ', '-', $request->title) . '_' . 'submission' . '.' . $extension;
            $request->file('submission_file')->move('uploads/submissionFiles', $submissionFileName);
            $submission->file = $submissionFileName;
        }
        $submission->save();

        $authors = $request->get('authors');
        if (!empty($authors)) {
            foreach ($authors as $aid => $author) {
                $newHash = md5($author['first_name'].$author['last_name'].$author['email'].$author['affiliation'].$author['country']);

                $submissionAuthor = SubmissionAuthor::where('submission_id', $submission->id)->where('email', $author['email'])->first();

                if ($submissionAuthor) {
                    $submissionAuthor->submission_id = $id;
                    $submissionAuthor->first_name = $author['first_name'];
                    $submissionAuthor->last_name = $author['last_name'];
                    $submissionAuthor->email = $author['email'];
                    $submissionAuthor->country_id = $author['country'];
                    $submissionAuthor->affiliation = $author['affiliation'];
                    $submissionAuthor->save();
                } else {
                    $newAuthor = new SubmissionAuthor;
                    $newAuthor->submission_id = $id;
                    $newAuthor->first_name = $author['first_name'];
                    $newAuthor->last_name = $author['last_name'];
                    $newAuthor->email = $author['email'];
                    $newAuthor->affiliation = $author['affiliation'];
                    $newAuthor->country_id = $author['country'];
                    $newAuthor->hash = md5($author['first_name'].$author['last_name'].$author['email'].$author['affiliation'].$author['country']);
                    $newAuthor->save();
                }
            }
        }

        if (!empty($request->file('supplementary_file'))) {
            foreach ($request->file('supplementary_file') as $file) {
                $submissionFile = new SubmissionFile();
                $submissionFile->submission_id = $submission->id;
                $extension = $file->getClientOriginalExtension();
                $supplementaryFile = str_replace(' ', '', $request->title) . '_' . 'supplementary' . '.' . $extension;
                $file->move('uploads/supplementaryFiles', $supplementaryFile);
                $submissionFile->filename = $supplementaryFile;
                $submissionFile->save();
            }
        }

        return redirect('/submissions')->with('success', 'Submission updated successfully.');
    }

    public function deleteAuthor($id)
    {
        try {

            $submissionAuthor = SubmissionAuthor::find($id);
            if ($submissionAuthor) {
                $submissionAuthor->delete();
            }

            return response()->json([
                'status' => 'success',
            ]);

        } catch (\Exception $e) {

            info($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Could not delete the author!',
            ]);
        }
    }


    public function addRevision(Request $request, $id)
    {

        $rules['author_version'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('submissions/' . $id . '/review')
                ->withErrors($validator)
                ->withInput();
        }

        $statusConfirmed = SubmissionReviewer::where('status', 1)->count();
        $submissionReviewers = Submission::where('parent_id', $id)->distinct()->count('reviewer_id');

        $submission = Submission::findOrFail($id);
        if ($request->hasFile('author_version')) {
            $authorFile = $request->author_version->getClientOriginalName();
            $request->file('author_version')->move('uploads/authorFiles', $authorFile);

        }

        if ($statusConfirmed == $submissionReviewers) {
            $submission->status = 3;
        } else {
            $submission->status = 2;
        }
        $submission->file = $authorFile;
        $submission->save();


        return redirect('/submissions')->with('success', 'Revision file added successfully.');
    }

    public function deleteSubmissionFile($id)
    {
        $submission = Submission::findOrFail($id);

        if (!empty($submission->file)) {
            if (file_exists(public_path('uploads/submissionFiles/' . $submission->file . ''))) {
                unlink(public_path('uploads/submissionFiles/' . $submission->file . ''));
            }
            $submission->file = null;
            $submission->save();
        }

        return redirect('submissions/' . $id . '/edit');
    }

    public function deleteCoverLetter($id)
    {
        $submission = Submission::findOrFail($id);

        if (!empty($submission->cover_letter)) {
            if (file_exists(public_path('uploads/coverLetters/' . $submission->cover_letter . ''))) {
                unlink(public_path('uploads/coverLetters/' . $submission->cover_letter . ''));
            }
            $submission->cover_letter = null;
            $submission->save();
        }

        return redirect('submissions/' . $id . '/edit');
    }

    public function deleteSupplementaryFiles($id)
    {
        try{
            $submissionFile = SubmissionFile::findOrFail($id);

            if (file_exists(public_path('uploads/supplementaryFile/' . $submissionFile->filename . ''))) {
                @unlink(public_path('uploads/supplementaryFile/' . $submissionFile->filename . ''));
            }
            $submissionFile->delete();
        } catch(\Exception $e) {
            info($e->getMessage());
        }

        return redirect('submissions/' . $submissionFile->submission->id . '/edit')
            ->with('success', 'Submission file succesfully deleted!');
    }

    public function messages($id)
    {
        $messages = ChatMessage::where('submission_id', $id)
            ->where('to', 'author')
            ->get();

        return view('submission.messages')
            ->with('submissionId', $id)
            ->with('messages', $messages);
    }
}
