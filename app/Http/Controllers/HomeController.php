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
    public function home()
    {
        $posts = (new Post)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip(0)
            ->orderBy('created_at','desc')->get();

        return view('home')
            ->with('posts', $posts)
            ->with('page_title', 'Home page')
            ->with('search_url', 'home')
            ->with('scroll_url', 'home');
    }

    public function scroll($skip)
    {
        $posts = (new Post)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip((int)$skip * 5)
            ->orderBy('created_at','desc')->get();

        return view('partials.scroll', ['posts' => $posts]);
    }

    public function scrollSearch($search, $skip)
    {
        $posts = (new Post)->withCount('comments')
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
        $posts = (new Post)->withCount('comments')
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
            ->with('page_title', "Search: {$search}")
            ->with('search_url', "home")
            ->with('scroll_url', "home/search/{$search}");
    }
}
