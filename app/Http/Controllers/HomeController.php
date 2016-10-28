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
    public function home()
    {
        $this->postScroll->setSkip(0);
        $posts = $this->postScroll->scroll((new Post));
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', 'Home page')
            ->with('search_url', 'home')
            ->with('scroll_url', 'home');
    }

    public function scroll($skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new Post));

        return view('partials.scroll', ['posts' => $posts]);
    }

    public function scrollSearch($search, $skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scrollSearch((new Post), $search);
        return view('partials.scroll', ['posts' => $posts]);
    }

    public function searchRedirect(Request $request)
    {
        $search = $request->input('q');

        if (!empty($search)) {
            return redirect('home/search/' . $search);
        }
        return view('empty')
            ->with('page_title', 'Search:  result is empty')
            ->with('search_url', "home")
            ->with('scroll_url', "home");

    }

    public function search($search)
    {
        $posts = $this->postScroll->scrollSearch((new Post), $search);
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "Search: {$search}")
            ->with('search_url', "home")
            ->with('scroll_url', "home/search/{$search}");
    }
}
