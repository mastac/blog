<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostScrollService;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{

    /**
     * @var PostScrollService
     */
    private $postScroll;

    public function __construct(PostScrollService $postScroll)
    {
        $this->middleware('auth',['except' => 'getPostByTag']);
        $this->postScroll = $postScroll;
    }

    /**
     * Get page with the tag
     * @param $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tagName($tag)
    {
        $posts = $this->postScroll->scroll((new Tag)->getPostsByTagName($tag));
        return view('posts.list')->with('posts', $posts);
    }

    public function scroll( $tag, $skip )
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new Tag)->getPostsByTagName($tag));
        return view('partials.scroll', ['posts' => $posts]);
    }
}
