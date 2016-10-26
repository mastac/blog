<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::withCount('comments')
            ->with('tags')
            ->with('comments')
            ->orderBy('created_at', 'desc')->take(5)->get();
//        dd($posts->tags());
        return view('home')->with('posts', $posts);
    }
}
