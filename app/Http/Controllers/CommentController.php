<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{

    public function getComments($id)
    {
        $comments = Comment::wherePostId($id)->get();
        return view('partials.comments')->with('comments', $comments);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'comment' => 'required',
        ]);

        Comment::create($request->all());
        return back();
    }
}
