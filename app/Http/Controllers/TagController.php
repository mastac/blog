<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{

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

        $posts = (new Tag)->getPostsByTagName($tag)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip(0)
            ->orderBy('created_at','desc')->get();

        return view('home')
            ->with('posts', $posts)
            ->with('page_title', 'Tag: '. $tag)
            ->with('search_url', 'tags/' . $tag)
            ->with('scroll_url', 'tags/' . $tag);
    }

    public function scrollByTagName( $tag, $skip )
    {
        $posts = (new Tag)->getPostsByTagName($tag)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip((int)$skip * 5)
            ->orderBy('created_at','desc')->get();

        return view('partials.scroll', ['posts' => $posts]);
    }

    public function searchByTagName($tag, $search)
    {

        $posts = (new Tag)->getPostsByTagName($tag)->withCount('comments')
            ->with('tags')
            ->where(function($query) use ($search){
                $query->where('name','like', '%'.$search.'%')
                    ->orWhere('text','like', '%'.$search.'%');
            })
            ->take(5)
            ->skip(0)
            ->orderBy('created_at','desc')->get();

        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "Tag: {$tag}, Search: {$search}")
            ->with('entry', "tags/{$tag}/search/{$search}")
            ->with('search_url', "tags/{$tag}")
            ->with('scroll_url', "tags/{$tag}/search/{$search}");
    }

    public function scrollSearchByTagName($tag, $search, $skip)
    {
        $posts = (new Tag)->getPostsByTagName($tag)->withCount('comments')
            ->with('tags')
            ->where(function($query) use ($search){
                $query->where('name','like', '%'.$search.'%')
                    ->orWhere('text','like', '%'.$search.'%');
            })
            ->take(5)
            ->skip((int) $skip * 5)
            ->orderBy('created_at','desc')->get();
        return view('partials.scroll', ['posts' => $posts]);
    }
}
