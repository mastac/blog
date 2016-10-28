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
        $this->postScroll = $postScroll;
    }

    public function searchRedirect(Request $request, $tag)
    {
        $search = $request->input('q');

        if (!empty($search)) {
            return redirect("tags/{$tag}/search/{$search}");
        }
        return view('empty')
            ->with('page_title', 'Tags: '. $tag . ', Search: Result is empty')
            ->with('search_url', 'tags/' . $tag)
            ->with('scroll_url', 'tags/' . $tag)
            ->withErrors(['search', 'The search is empty']);
    }

    /**
     * Get page with the tag
     * @param $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tagByName($tag)
    {
        $posts = $this->postScroll->scroll((new Tag)->getPostsByTagName($tag));
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', 'Tag: '. $tag)
            ->with('search_url', 'tags/' . $tag)
            ->with('scroll_url', 'tags/' . $tag);
    }

    public function scrollByTagName( $tag, $skip )
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new Tag)->getPostsByTagName($tag));
        return view('partials.scroll', ['posts' => $posts]);
    }

    public function searchByTagName($tag, $search)
    {
        $posts = $this->postScroll->scrollSearch((new Tag)->getPostsByTagName($tag), $search);
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "Tag: {$tag}, Search: {$search}")
            ->with('entry', "tags/{$tag}/search/{$search}")
            ->with('search_url', "tags/{$tag}")
            ->with('scroll_url', "tags/{$tag}/search/{$search}");
    }

    public function scrollSearchByTagName($tag, $search, $skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scrollSearch((new Tag)->getPostsByTagName($tag), $search);
        return view('partials.scroll', ['posts' => $posts]);
    }
}
