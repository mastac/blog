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
            'email' => 'email'
        ]);

        Comment::create($request->all());
        return back();
    }

    public function setLikeAndDislike(Request $request, $state, $comment_id)
    {
        $likes = \App\Comment::with('likes')->find($comment_id)->likes()->firstOrNew(['ip' => $request->ip()]);

        if ($state === 'like')
            $likes->state = 'like';
        elseif($state === 'dislike')
            $likes->state = 'dislike';
        else
            $likes->state = 'neutral';

        $likes->save();

        $comment = \App\Comment::find($comment_id);

        return \Response::json(['id' => $comment->id,'like' => $comment->like, 'dislike' => $comment->dislike]);
    }
}
