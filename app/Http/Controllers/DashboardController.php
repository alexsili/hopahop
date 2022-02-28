<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect('users');
        }
        if ($user->isUsual()) {
            return redirect('users');
        }

//        if ($user->isAuthor() && $user->isReviewer()) {
//            $activeSubmissions = Submission::where('status', 4)->where('parent_id', null)->where('author_id', $user->id)->count();
//            $archivedSubmissions = Submission::whereIn('status', [5, 6])->where('parent_id', null)->where('author_id', $user->id)->count();
//
//            $inReviewSubmissions = Submission::where('status', 2)->where('parent_id', null)->count();
//            $assignedSubmissions = Submission::where('status', 1)->where('parent_id', null)->count();
//            $inEditingSubmissions = Submission::where('status', 3)->where('parent_id', null)->count();
//
//            return view('dashboard.author-reviewer')
//                ->with('activeSubmissions', $activeSubmissions)
//                ->with('archivedSubmissions', $archivedSubmissions)
//                ->with('inReviewSubmissions', $inReviewSubmissions)
//                ->with('assignedSubmissions', $assignedSubmissions)
//                ->with('inEditingSubmissions', $inEditingSubmissions);
//        }
//
//        if ($user->isAuthor()) {
//            $activeSubmissions = Submission::where('status', 4)->where('parent_id', null)->where('author_id', $user->id)->count();
//            $archivedSubmissions = Submission::whereIn('status', [5, 6])->where('parent_id', null)->where('author_id', $user->id)->count();
//
//            return view('dashboard.author')
//                ->with('activeSubmissions', $activeSubmissions)
//                ->with('archivedSubmissions', $archivedSubmissions);
//        }
//
//        if ($user->isReviewer()) {
//            $activeSubmissions = Submission::where('status', 2)->where('parent_id', null)->count();
//            $assignedSubmissions = Submission::where('status', 1)->where('parent_id', null)->count();
//            $inEditingSubmissions = Submission::where('status', 3)->where('parent_id', null)->count();
//
//            return view('dashboard.reviewer')
//                ->with('activeSubmissions', $activeSubmissions)
//                ->with('assignedSubmissions', $assignedSubmissions)
//                ->with('inEditingSubmissions', $inEditingSubmissions);
//        }
//
//        if ($user->isEditor()) {
//            $unassignedSubmissions = Submission::where('status', 0)->where('parent_id', null)->count();
//            $assignedSubmissions = Submission::where('status', 1)->where('parent_id', null)->count();
//            $dueAssignedSubmissions = Submission::where('status', 1)->where('parent_id', null)->whereDate('due_date', now())->count();
//            $inReviewSubmissions = Submission::whereIn('status', [2, 3, 4])->where('parent_id', null)->count();
//            $inEditingSubmissions = Submission::where('status', 3)->where('parent_id', null)->count();
//
//            return view('dashboard.editor')
//                ->with('unassignedSubmissions', $unassignedSubmissions)
//                ->with('assignedSubmissions', $assignedSubmissions)
//                ->with('dueAssignedSubmissions', $dueAssignedSubmissions)
//                ->with('inReviewSubmissions', $inReviewSubmissions)
//                ->with('inEditingSubmissions', $inEditingSubmissions);
//        }


        return view('dashboard.index');
    }
}
