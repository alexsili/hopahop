<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Submission;
use App\Models\SubmissionReviewer;
use App\Models\User;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $unAssigned = Submission::where('status', 0)
            ->where('parent_id', null)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('editor.unassigned')
            ->with('unAssigned', $unAssigned);

    }

    public function author()
    {
        $active = Submission::where('status', 4)
            ->where('parent_id', null)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('editor.author')
            ->with('active', $active);

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function assigned()
    {
        $assigned = Submission::where('status', 1)->get();

        return view('editor.assigned')
            ->with('assigned', $assigned);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function inreview()
    {
        $inReview = Submission::whereIn('status', [2, 3, 4])
            ->where('parent_id', null)
            ->get();

        return view('editor.inreview')
            ->with('inReview', $inReview);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function inediting()
    {
        $inEditing = Submission::where('status', 3)->where('parent_id', null)->get();

        return view('editor.inediting')
            ->with('inEditing', $inEditing);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $submission = Submission::findOrFail($id);

        foreach ($submission->messages as $message) {
            $message->viewed = 1;
            $message->save();
        }

        return view('editor.show')
            ->with('submission', $submission);
    }

    /**\
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function search(Request $request, $id)
    {
        return redirect('/editor/select-reviewers/' . $id . '?author=' . $request->get('author') . '&research=' . $request->get('research') . '&country=' . $request->get('country'));
    }

    /**
     * @param Request $request
     * @param $submissionId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function selectReviewers(Request $request, $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        $reviewers = User::where('roles', 'LIKE', '%reviewer%')
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->get();
        $countries = Country::pluck('name', 'id')->toArray();
        $userSearch = User::where('roles', 'LIKE', '%reviewer%')
            ->where(function ($query) use ($request) {
                if ($request->get('author') != '') {
                    $query->orWhere('id', (int)$request->get('author'));
                }
                if ($request->get('research') != '') {
                    $query->orWhere('research_field', $request->get('research'));
                }
                if ($request->get('country') != '') {
                    $query->orWhere('country_id', (int)$request->get('country'));
                }
            })
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->paginate(10);

        return view('editor.invite')
            ->with('submission', $submission)
            ->with('reviewers', $reviewers)
            ->with('countries', $countries)
            ->with('userSearch', $userSearch);
    }

    /**
     * @param Request $request
     * @param $submissionId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSelectedReviewers(Request $request, $submissionId)
    {

        $submissionAuthor = Submission::select('author_id')->where('id', $submissionId)->get();
        $reviewerIds = $request->get('reviewerId');

        foreach ($submissionAuthor as $author) {
            if (in_array($author->author_id, $reviewerIds)) {
                return redirect()->route('editorSelectReviewers', $submissionId)->with('error', 'An author cannot review his own submission');
            }
        }

        if (empty($reviewerIds)) {
            return redirect()->route('editorSelectReviewers', $submissionId)->with('error', 'You must choose at least one reviewer');
        }

        return redirect('/editor/confirm-selected-reviewers/' . $submissionId . '/' . implode("-", $reviewerIds));

    }

    /**
     * @param $submissionId
     * @param $reviewerIds
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmSelectedReviewers($submissionId, $reviewerIds)
    {
        $submission = Submission::findOrFail($submissionId);
        $reviewerIdsArr = array_unique(explode("-", $reviewerIds));

        if (empty($reviewerIdsArr)) {
            return redirect()->route('editorSelectReviewers', $submissionId)->with('error', 'You must choose at least one reviewer');
        }

        $users = User::findMany($reviewerIdsArr);

        return view('editor.assign-submission')
            ->with('submission', $submission)
            ->with('users', $users);
    }

    public function confirmReviewersData(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        $submission->due_date = $request->get('due-date');
        $submission->status = 1;
        $submission->save();

        $reviewersIds = $request->get('reviewer-id');
        if (count($reviewersIds)) {
            foreach ($reviewersIds as $reviewerId) {
                $submissionReviewer = new SubmissionReviewer();
                $submissionReviewer->submission_id = $id;
                $submissionReviewer->reviewer_id = $reviewerId;
                $submissionReviewer->status = 0;
                $submissionReviewer->save();
            }
        } else {
            return redirect()->route('editorSelectReviewers', $id)->with('error', 'You must choose at least one reviewer');
        }

        //@TODO: send emails to reviewers

        return redirect('editor');
    }
}
