<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

        $articles = Article::where('deleted_at', null)
            ->get();


        return view('dashboard')->with('articles', $articles);
    }
}
