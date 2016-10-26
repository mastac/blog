<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except' => 'getPostByTag']);
    }

    public function getPostByTag($tag)
    {
        $tag = Tag::whereName($tag)->first();
        abort_if($tag === null, 404);

        $posts = $tag->posts()->orderBy('created_at','desc')->get();
        return view('posts.list')->with('posts', $posts);
    }
}
