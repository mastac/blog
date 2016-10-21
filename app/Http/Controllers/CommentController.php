<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{

    public function getComments($id)
    {
        return response()->json(Comment::wherePostId($id)->get()->toJson());
    }

    public function store()
    {
        $comment = Comment::create([
            'post_id' => request('post_id'),
            'name' => request('name'),
            'email' => request('email'),
            'comment' => request('comment')
        ]);

        return back();
    }
}
