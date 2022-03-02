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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $articles = Article::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('article.index')
            ->with('articles', $articles);
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');

        return view('article.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $rules['title'] = 'required|string|max:255';
        $rules['description'] = 'required|string|max:50000';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('articles/create')
                ->withErrors($validator)
                ->withInput();
        }

        $article = new Article();
        $article->user_id = Auth::user()->id;
        $article->category_id = $request->get('category');
        $article->title = $request->get('title');
        $article->description = $request->get('description');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '', $request->title) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/images', $image);
            $article->image = $image;
        }

        $article->save();

        return redirect('/articles')->with('success', 'Article created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $article = Article::where('id', $id)
            ->first();

        if ($article == null) {
            return redirect('/articles')->with('error', 'Article not found!');
        }

        $categories = Category::pluck('name', 'id');

        return view('article.edit')
            ->with('categories', $categories)
            ->with('article', $article);
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
        $article = Article::find($id);

        $rules['title'] = 'required|string|max:255';
        $rules['description'] = 'required|string|max:50000';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';

        if ($article->image == null) {
            $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        } else {
            $rules['image'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('articles/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $article->user_id = Auth::user()->id;
        $article->category_id = $request->get('category');
        $article->title = $request->get('title');
        $article->description = $request->get('description');

        if ($request->hasFile('image')) {
            if (file_exists(public_path('uploads/images/' . $article->image . '')) && !empty($article->image)) {
                unlink(public_path('uploads/images/' . $article->image . ''));
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '-', $request->title) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/images', $image);
            $article->image = $image;
        }

        $article->save();

        return redirect('/articles')->with('success', 'Article updated successfully.');
    }

    public function deleteArticle($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $article = Article::findOrFail($id);;

            if ($article) {
                $article->delete();
                return redirect()->route('articleIndex')
                    ->with('success', 'Article deleted successfully');
            }
        } else {
            return redirect()->route('articleIndex')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect()->route('articleIndex');

    }


    public function deleteArticleImage($id)
    {

        if (Auth::user()->isAdmin()) { // only admin can delete users
            $article = Article::findOrFail($id);;

            if ($article->image) {
                if (file_exists(public_path('uploads/images/' . $article->image . ''))) {
                    unlink(public_path('uploads/images/' . $article->image . ''));
                }
                $article->image = null;
                $article->save();
                return redirect()->route('articleIndex')
                    ->with('success', 'Article deleted successfully');
            }
        } else {
            return redirect()->route('articleIndex')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect('articles/' . $id . '/edit');


//        if (!empty($article->image)) {
//            if (file_exists(public_path('uploads/images/' . $article->image . ''))) {
//                unlink(public_path('uploads/images/' . $article->image . ''));
//            }
//            $article->image = null;
//            $article->save();
//        }
//
//        return redirect('articles/' . $id . '/edit');
    }
}
