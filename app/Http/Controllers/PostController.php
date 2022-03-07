<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Personage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $comments = Comment::where('article_id', $id)
            ->where('approved', 1)
            ->get();

        return view('post.single-article')
            ->with('comments', $comments)
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about()
    {
        $personages = Personage::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('post.about')
            ->with('personages', $personages);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact()
    {
        $countries = Country::pluck('name', 'id');

        return view('post.contact')
            ->with('countries', $countries);
    }

    public function contactMessage(Request $request)
    {
        $rules['name'] = 'required|string|max:255';
        $rules['country'] = 'required|string|max:255';
        $rules['message'] = 'required|string|max:50000';
        $rules['email'] = 'required|email|unique:users,email,' . 0;

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('contact'))
                ->withErrors($validator)
                ->withInput();
        }

        $comment = new Contact();
        $comment->name = $request->get('name');
        $comment->phone = $request->get('phone');
        $comment->email = $request->get('email');
        $comment->message = $request->get('message');
        $comment->country_id = $request->get('country');

        $comment->save();

        return redirect(route('contact'))->with('success', 'Message send successfully.');

    }

    public function downloadDrawingImage(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $file = "uploads/images/" . $article->image . "";

        $headers = ['Content-Type: image/jpeg'];

        if (file_exists($file)) {
            return \Response::download($file, "{$article->image}", $headers);
        } else {
            echo('File not found.');
        }
    }
}
