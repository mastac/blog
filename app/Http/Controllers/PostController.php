<?php

namespace App\Http\Controllers;

use App\Helpers\Nav;
use App\Post;

use App\Http\Requests;

class PostController extends Controller
{

    /**
     * Display the Post.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /**
         * FIXME: Строка ниже выдаете мне пустой $post->tags
         */
        // $post = Post::find($id)->with('tags')->first();
        /**
         * а следеющая выдает выдает нормальный, В чем проблема
         */
        $post = Post::whereId($id)->with('tags')->first();
        return view('theme.single_post',compact('post'))
            ->with('page_title', $post->name)
            ->with('search_url', 'home');
    }



    public function test()
    {
        //<iframe width="854" height="480" src="https://www.youtube.com/embed/Qjjqu8-MxHU" frameborder="0" allowfullscreen></iframe>
        $id = $this->youtube_id_from_url('https://www.youtube.com/watch?v=Qjjqu8-MxHU');
        $id2 = $this->youtube_id_from_url('https://www.youtube.com/embed/Qjjqu8-MxHU');
        dd($id, $id2);
    }

}
