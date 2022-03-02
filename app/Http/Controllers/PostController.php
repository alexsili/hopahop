<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Personage;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('post.home');
    }

    public function singleArticle($id)
    {
        $article = Article::findOrFail($id);

        return view('post.single-article')
            ->with('article', $article);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * category_id = 3 (songs)
     */
    public function songs()
    {
        $articles = Article::where('category_id', 1)
            ->orderBy('updated_at', 'DESC')
            ->where('deleted_at', null)
            ->paginate(9);

        return view('post.songs')
            ->with('articles', $articles);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * category_id = 2 (drawings)
     */
    public function drawings()
    {
        $articles = Article::where('category_id', 2)
            ->orderBy('updated_at', 'DESC')
            ->where('deleted_at', null)
            ->paginate(9);

        return view('post.drawings')
            ->with('articles', $articles);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * category_id = 3 (sport)
     */
    public function sport()
    {
        $articles = Article::where('category_id', 3)
            ->where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(9);

        return view('post.sports')
            ->with('articles', $articles);
    }

    public function about()
    {
        $articles = Personage::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('post.about')
            ->with('articles', $articles);
    }


    public function contact()
    {
        return view('post.contact');
    }


}
