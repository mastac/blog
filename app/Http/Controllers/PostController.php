<?php

namespace App\Http\Controllers;

use App\Post;

use App\Http\Requests;

class PostController extends Controller
{

    /**
     * Display the Post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show',compact('post'));
    }

}
