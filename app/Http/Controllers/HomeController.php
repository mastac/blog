<?php

namespace App\Http\Controllers;

use App\Services\PostScrollService;
use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    /**
     * @var PostScrollService
     */
    private $postScroll;

    public function __construct(PostScrollService $postScroll)
    {
        $this->postScroll = $postScroll;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->postScroll->setSkip(0);
        $posts = $this->postScroll->scroll((new Post));
        return view('home')->with('posts', $posts)->with('page_title', 'Home page');
    }

    public function scroll($skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new Post));

        return view('partials.scroll', ['posts' => $posts]);
    }
}
