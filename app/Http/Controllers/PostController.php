<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Mail\SubmissionNewAuthor;
use App\Mail\SubmissionNewEditor;
use App\Models\Article;
use App\Models\Category;
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

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $articles = Article::where('deleted_at', null)
            ->paginate(9);

        return view('post.home')
            ->with('articles', $articles);
    }

    public function singleArticle($id)
    {
        $article = Article::findOrFail($id);

        return view('post.article')
            ->with('article', $article);
    }

    public function songs()
    {
        $articles = Article::where('deleted_at', null)
            ->paginate(9);

        return view('post.songs')
            ->with('articles', $articles);
    }

    public function drawings()
    {
        $articles = Article::where('deleted_at', null)
            ->paginate(9);

        return view('post.home')
            ->with('articles', $articles);
    }

    public function about()
    {
        $articles = Article::where('deleted_at', null)
            ->get();

        return view('post.home')
            ->with('articles', $articles);
    }

    public function contact()
    {
        $articles = Article::where('deleted_at', null)
            ->get();

        return view('post.home')
            ->with('articles', $articles);
    }
}
