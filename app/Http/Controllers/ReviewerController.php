<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Models\ChatMessage;
use App\Models\Submission;
use App\Models\SubmissionReviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $assignedSubmissions = Submission::where('status', 1)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->get();

        $activeSubmissions = Submission::where('status', 2)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        $archivedSubmissions = Submission::whereIn('status', [5, 6])
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        return view('reviewer.new')
            ->with('assignedSubmissions', $assignedSubmissions)
            ->with('activeSubmissions', $activeSubmissions)
            ->with('archivedSubmissions', $archivedSubmissions);
    }

    public function active()
    {
        $activeSubmissions = Submission::where('status', 2)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->get();
        $assignedSubmissions = Submission::where('status', 1)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        $archivedSubmissions = Submission::whereIn('status', [5, 6])
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        return view('reviewer.active')
            ->with('activeSubmissions', $activeSubmissions)
            ->with('assignedSubmissions', $assignedSubmissions)
            ->with('archivedSubmissions', $archivedSubmissions);
    }

    public function archive()
    {
        $activeSubmissions = Submission::where('status', 2)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        $assignedSubmissions = Submission::where('status', 1)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        $inEditingSubmissions = Submission::where('status', 3)
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->count();

        $archivedSubmissions = Submission::whereIn('status', [5, 6])
            ->where('parent_id', null)
            ->where('author_id', '!=', Auth::user()->id)
            ->get();


        return view('reviewer.archive')
            ->with('archivedSubmissions', $archivedSubmissions)
            ->with('activeSubmissions', $activeSubmissions)
            ->with('assignedSubmissions', $assignedSubmissions)
            ->with('inEditingSubmissions', $inEditingSubmissions);
    }

    public function show($id)
    {
        $submission = Submission::findOrFail($id);

        return view('reviewer.show')
            ->with('submission', $submission);
    }

    public function getSummary($id)
    {
        $submission = Submission::findOrFail($id);
        $submissionMessages = ChatMessage::where('submission_id', $id)->first();

        return view('reviewer.summary')
            ->with('submission', $submission)
            ->with('submissionMessages', $submissionMessages);
    }

    public function getReview($id)
    {
        $submission = Submission::findOrFail($id);

        return view('reviewer.review')
            ->with('submission', $submission);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postResponse(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $rules['reviewer_decision'] = 'required|int|max:11';
        $rules['message'] = 'required|string';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('reviewer/summary/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        $decision = SubmissionReviewer::where('submission_id', $submission->id)
            ->where('reviewer_id', Auth::user()->id)
            ->first();

        if ($decision) {
            $decision->status = $request->get('reviewer_decision');
            $decision->save();
        }

        Helper::checkSubmissionDenied($submission);

        $submissionMessage = new ChatMessage();
        $submissionMessage->submission_id = $submission->id;
        $submissionMessage->from = 'reviewer';
        $submissionMessage->to = 'editor';
        $submissionMessage->created_by = Auth::user()->id;
        $submissionMessage->content = trim(htmlentities($request->get('message')));
        $submissionMessage->save();

        return redirect('reviewer/summary/' . $id);
    }

    public function postReviewNew(Request $request, $id)
    {
        // manuscript_contains
        $rules['new'] = 'required_without_all:important,irrelevant';
        $rules['important'] = 'required_without_all:new,irrelevant';
        $rules['irrelevant'] = 'required_without_all:important,new';

        // objectives
        $rules['clear'] = 'required_without_all:unclear,missing';
        $rules['unclear'] = 'required_without_all:clear,missing';
        $rules['missing'] = 'required_without_all:clear,unclear';

        // experiments
        $rules['relevant-experiments'] = 'required_without_all:irrelevant-experiments';
        $rules['irrelevant-experiments'] = 'required_without_all:relevant-experiments';

        // materials
        $rules['clear-methods'] = 'required_without_all:repeatable-methods,withoutDetails';
        $rules['repeatable-methods'] = 'required_without_all:clear-methods,withoutDetails';
        $rules['withoutDetails'] = 'required_without_all:clear-methods,repeatable-methods';

        // bibliography
        $rules['current-bibliography'] = 'required_without_all:old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['old-bibliography'] = 'required_without_all:current-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['necessary-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['irrelevant-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['complete-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,incomplete-bibliography,citedInText';
        $rules['incomplete-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,citedInText';
        $rules['citedInText'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography';

        // tables
        $rules['required-tables'] = 'required_without_all:unnecessary-tables';
        $rules['unnecessary-tables'] = 'required_without_all:required-tables';

        // conclusions
        $rules['supported'] = 'required_without_all:unsupported';
        $rules['unsupported'] = 'required_without_all:supported';

        $rules['review_file'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        $rules['recommendation'] = 'required';
        $rules['suggestions'] = 'required';
        $rules['message'] = 'required|string|min:3|max:5000';

        $manuscripts = implode(",", array_filter([$request->get('new') ?? '', $request->get('important') ?? '', $request->get('irrelevant') ?? '']));
        $objectives = implode(",", array_filter([$request->get('clear') ?? '', $request->get('unclear') ?? '', $request->get('missing') ?? '']));
        $experiments = implode(",", array_filter([$request->get('relevant-experiments') ?? '', $request->get('relevant-experiments') ?? '']));
        $materials = implode(",", array_filter([$request->get('clear-methods') ?? '', $request->get('repeatable-methods') ?? '']));
        $bibliography = implode(",", array_filter([
            $request->get('current-bibliography') ?? '',
            $request->get('old-bibliography') ?? '',
            $request->get('necessary-bibliography') ?? '',
            $request->get('irrelevant-bibliography') ?? '',
            $request->get('complete-bibliography') ?? '',
            $request->get('incomplete-bibliography') ?? '',
            $request->get('citedInText') ?? ''
        ]));
        $tables = implode(",", array_filter([$request->get('required-tables') ?? '', $request->get('unnecessary-tables') ?? '']));
        $conclusions = implode(",", array_filter([$request->get('supported') ?? '', $request->get('unsupported') ?? '']));


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('reviewer/review/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        $submission = Submission::findOrFail($id);
        $submission->status = 4;
        $submission->save();

        $submissionWithParent = new Submission;
        $submissionWithParent->parent_id = $submission->id;
        $submissionWithParent->round = $submission->getRevisions()->count() > 0 ? $submission->getRevisions()->last()->round + 1 : 1;
        if ($request->hasFile('review_file')) {
            if (file_exists(public_path('uploads/reviewerFile/' . $submissionWithParent->reviewer_file . '')) && !empty($submissionWithParent->reviewer_file)) {
                unlink(public_path('uploads/reviewerFile/' . $submissionWithParent->reviewer_file . ''));
            }
            $extension = $request->file('review_file')->getClientOriginalExtension();
            $reviewerFile = str_replace(' ', '', $submissionWithParent->title) . '_' . 'review_file' . '.' . $extension;
            $request->file('review_file')->move('uploads/reviewerFile', $reviewerFile);
            $submissionWithParent->reviewer_file = $reviewerFile;
        }

        $submissionWithParent->manuscript_contains = $manuscripts;
        $submissionWithParent->objectives = $objectives;
        $submissionWithParent->experiments = $experiments;
        $submissionWithParent->materials = $materials;
        $submissionWithParent->bibliography = $bibliography;
        $submissionWithParent->tables = $tables;
        $submissionWithParent->conclusions = $conclusions;
        $submissionWithParent->suggestions = $request->get('suggestions');
        $submissionWithParent->recomendation = $request->get('recommendation');
        $submissionWithParent->reviewer_file = $reviewerFile;
        $submissionWithParent->status = NULL;
        $submissionWithParent->save();


        $submissionMessage = new ChatMessage();
        $submissionMessage->submission_id = $submission->id;
        $submissionMessage->from = 'reviewer';
        $submissionMessage->to = 'editor';
        $submissionMessage->created_by = Auth::user()->id;
        $submissionMessage->content = trim(htmlentities($request->get('msg')));
        $submissionMessage->save();

        return redirect('reviewer');
    }

    public function postReviewActive(Request $request, $id)
    {
        // manuscript_contains
        $rules['new'] = 'required_without_all:important,irrelevant';
        $rules['important'] = 'required_without_all:new,irrelevant';
        $rules['irrelevant'] = 'required_without_all:important,new';

        // objectives
        $rules['clear'] = 'required_without_all:unclear,missing';
        $rules['unclear'] = 'required_without_all:clear,missing';
        $rules['missing'] = 'required_without_all:clear,unclear';

        // experiments
        $rules['relevant-experiments'] = 'required_without_all:irrelevant-experiments';
        $rules['irrelevant-experiments'] = 'required_without_all:relevant-experiments';

        // materials
        $rules['clear-methods'] = 'required_without_all:repeatable-methods,withoutDetails';
        $rules['repeatable-methods'] = 'required_without_all:clear-methods,withoutDetails';
        $rules['withoutDetails'] = 'required_without_all:clear-methods,repeatable-methods';

        // bibliography
        $rules['current-bibliography'] = 'required_without_all:old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['old-bibliography'] = 'required_without_all:current-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['necessary-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['irrelevant-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,complete-bibliography,incomplete-bibliography,citedInText';
        $rules['complete-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,incomplete-bibliography,citedInText';
        $rules['incomplete-bibliography'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,citedInText';
        $rules['citedInText'] = 'required_without_all:current-bibliography,old-bibliography,necessary-bibliography,irrelevant-bibliography,complete-bibliography,incomplete-bibliography';

        // tables
        $rules['required-tables'] = 'required_without_all:unnecessary-tables';
        $rules['unnecessary-tables'] = 'required_without_all:required-tables';

        // conclusions
        $rules['supported'] = 'required_without_all:unsupported';
        $rules['unsupported'] = 'required_without_all:supported';

        $rules['review_file'] = 'required|max:2048';
        $rules['recommendation'] = 'required';
        $rules['suggestions'] = 'required';
        $rules['msg'] = 'required';

        $manuscripts = implode(",", array_filter([$request->get('new') ?? '', $request->get('important') ?? '', $request->get('irrelevant') ?? '']));
        $objectives = implode(",", array_filter([$request->get('clear') ?? '', $request->get('unclear') ?? '', $request->get('missing') ?? '']));
        $experiments = implode(",", array_filter([$request->get('relevant-experiments') ?? '', $request->get('relevant-experiments') ?? '']));
        $materials = implode(",", array_filter([$request->get('clear-methods') ?? '', $request->get('repeatable-methods') ?? '']));
        $bibliography = implode(",", array_filter([
            $request->get('current-bibliography') ?? '',
            $request->get('old-bibliography') ?? '',
            $request->get('necessary-bibliography') ?? '',
            $request->get('irrelevant-bibliography') ?? '',
            $request->get('complete-bibliography') ?? '',
            $request->get('incomplete-bibliography') ?? '',
            $request->get('citedInText') ?? ''
        ]));
        $tables = implode(",", array_filter([$request->get('required-tables') ?? '', $request->get('unnecessary-tables') ?? '']));
        $conclusions = implode(",", array_filter([$request->get('supported') ?? '', $request->get('unsupported') ?? '']));


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('reviewer/show/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        $submission = Submission::findOrFail($id);
        $submission->status = 4;
        $submission->save();

        if ($request->hasFile('review_file')) {
            if (file_exists(public_path('uploads/reviewerFile/' . $submission->reviewer_file . '')) && !empty($submission->reviewer_file)) {
                unlink(public_path('uploads/reviewerFile/' . $submission->reviewer_file . ''));
            }
            $extension = $request->file('review_file')->getClientOriginalExtension();
            $reviewerFile = str_replace(' ', '', $submission->title) . '_' . 'review_file' . '.' . $extension;
            $request->file('review_file')->move('uploads/reviewerFile', $reviewerFile);
            $submission->reviewer_file = $reviewerFile;
        }

        $submissionWithParent = new Submission();
        $submissionWithParent->parent_id = $id;
        $submissionWithParent->round = $submission->getRevisions()->last()->round + 1;
        $submissionWithParent->author_id = $submission->author_id;
        $submissionWithParent->manuscript_contains = $manuscripts;
        $submissionWithParent->objectives = $objectives;
        $submissionWithParent->experiments = $experiments;
        $submissionWithParent->materials = $materials;
        $submissionWithParent->bibliography = $bibliography;
        $submissionWithParent->tables = $tables;
        $submissionWithParent->conclusions = $conclusions;
        $submissionWithParent->suggestions = $request->get('suggestions');
        $submissionWithParent->recomendation = $request->get('recommendation');
        $submissionWithParent->reviewer_file = $reviewerFile;
        $submissionWithParent->status = NULL;
        $submissionWithParent->save();

        $submissionMessage = new ChatMessage();
        $submissionMessage->submission_id = $submission->id;
        $submissionMessage->from = 'reviewer';
        $submissionMessage->to = 'editor';
        $submissionMessage->created_by = Auth::user()->id;
        $submissionMessage->content = trim(htmlentities($request->get('msg')));
        $submissionMessage->save();

        return redirect('reviewer');
    }
}
