<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{
    public function store()
    {
        $tagTerm = request()->input('q');
        $x = Tag::where('name','like',$tagTerm .'%')->get()->pluck('name', 'id')->toJson();
        return $x;
    }

    public function getPostByTag($tag)
    {
        $tag = Tag::whereName($tag)->first();
        abort_if($tag === null, 404);

        $posts = $tag->posts()->orderBy('created_at','desc')->get();
        return view('home')->with('posts', $posts);
    }
}
