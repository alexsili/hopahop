<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $comments = Comment::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('comments.index')
            ->with('comments', $comments);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $comment = Comment::where('id', $id)->first();

        if ($comment == null) {
            return redirect('/comments')->with('error', 'Comment message not found!');
        }

        return view('comments.show')
            ->with('comment', $comment);
    }


    public function deleteComment($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $comment = Comment::findOrFail($id);;

            if ($comment) {
                $comment->delete();
                return redirect()->route('commentIndex')
                    ->with('success', 'Comment message deleted successfully');
            }
        } else {
            return redirect()->route('commentIndex')
                ->with('warning', 'You don\'t have permissions to delete personages');
        }

        return redirect()->route('commentIndex');

    }

    public function approveComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->approved = 1;
        $comment->save();

        return redirect()->route('commentIndex')->with('succes', 'Comment approved with succes!');;

    }


    public function addComment(Request $request, $articleId)
    {
        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email|unique:users,email,' . 0;
        $rules['message'] = 'required|string|max:50000';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('singleArticle', $articleId))
                ->withErrors($validator)
                ->withInput();
        }

        $comment = new Comment();
        $comment->name = $request->get('name');
        $comment->email = $request->get('email');
        $comment->description = $request->get('message');
        $comment->article_id = $articleId;

        $comment->save();

        return redirect(route('singleArticle', $articleId))->with('success', 'Comment send successfully.');

    }
}
