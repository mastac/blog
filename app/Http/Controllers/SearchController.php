<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostScrollService;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    /**
     * @var PostScrollService
     */
    private $postScroll;

    /**
     * SearchController constructor.
     * @param PostScrollService $postScroll
     */
    public function __construct(PostScrollService $postScroll)
    {
        $this->postScroll = $postScroll;
    }

    public function scroll( $search, $skip )
    {
        $this->postScroll->setSkip($skip);

        $posts = Post::withCount('comments')->where(function($query) use ($search){
            $query->where('name','like', '%'.$search.'%')
                ->orWhere('text','like', '%'.$search.'%');
        });

        $this->postScroll->scroll($posts);
        return view('posts.list')->with('posts', $posts);
    }

}
