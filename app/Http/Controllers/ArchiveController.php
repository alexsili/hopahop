<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionAuthor;
use App\Models\SubmissionReviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class ArchiveController extends Controller
{

    private $area;

    public function __construct()
    {
        parent::__construct();
    }

    public function search(Request $request)
    {
        return redirect('http://arlsj.test/archives?title=' . $request->get('title') . '&author=' . $request->get('author') . '&section=' . $request->get('section') . '&year=' . $request->get('year') . '&status=' . $request->get('status'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $submissions = Submission::whereIn('status', [5, 6])
            ->where(function ($query) use ($request) {
                if ($request->get('title') != '') {
                    $query->orWhere('title', 'LIKE', '%' . $request->get('title') . '%');
                }
                if ($request->get('author') != '') {
                    $query->orWhereHas('authors', function ($q) use ($request) {
                        $q->where('id', (int)$request->get('author'));
                    });
                }
                if ($request->get('section') != '') {
                    $query->orWhere('section', $request->get('section'));
                }
                if ($request->get('year') != '') {
                    $query->orWhere('created_at', 'LIKE', '%' . $request->get('year') . '%');
                }
                if ($request->get('status') != '') {
                    if ($request->get('status') == 'Accepted') {
                        $query->orWhere('status', 5);
                    } elseif ($request->get('status') == 'Rejected') {
                        $query->orWhere('status', 6);
                    } else {
                        $query->orWhere('status', $request->get('status'));
                    }
                }
            });

        if (Auth::user()->isReviewer()) {
            $reviewerAcceptedSubmissions = SubmissionReviewer::select('submission_id')
                ->where('reviewer_id', Auth::user()->id)
                ->where('status', 1)
                ->get()
                ->toArray();
            $submissions = $submissions->whereIn('id', $reviewerAcceptedSubmissions)
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } elseif (Auth::user()->isAuthor()) {
            $submissions = $submissions->where('author_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->paginate(10);

        } else {
            $submissions = $submissions->orderBy('id', 'DESC')
                ->paginate(10);
        }

        $authors = SubmissionAuthor::select('id', 'first_name', 'last_name')
            ->distinct()
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->get();

        $years = ['2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015', '2014', '2013'];
        $archivedStatuses = ['Accepted', 'Rejected'];

        return view('archive.index')
            ->with('submissions', $submissions)
            ->with('authors', $authors)
            ->with('archivedStatuses', $archivedStatuses)
            ->with('years', $years);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        return view('archive.show')
            ->with('submission', $submission);
    }

}
