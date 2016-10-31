<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function postByUsername($username)
    {

        $posts = (new User)->getPostsByUsername($username)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip(0)
            ->orderBy('created_at','desc')->get();

        return view('home', ['posts' => $posts])
            ->with('page_title', 'User: '. $username)
            ->with('search_url', 'user/' . $username)
            ->with('scroll_url', 'user/' . $username);
    }

    public function scrollByUsername( $username, $skip )
    {
        $posts = (new User)->getPostsByUsername($username)->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip((int) $skip * 5)
            ->orderBy('created_at','desc')->get();

        return view('partials.scroll', ['posts' => $posts]);
    }

    public function searchEmpty($username)
    {
        return view('empty')
            ->with('page_title', 'User: '. $username . ' Search result is empty')
            ->with('search_url', 'user/' . $username)
            ->with('scroll_url', 'user/' . $username);
    }

    public function searchRedirect(Request $request, $username)
    {
        $search = $request->input('q');

        if (!empty($search)) {
            return redirect('user/' . $username . '/search/' . $search);
        }
        return view('empty')
            ->with('page_title', 'User: '. $username . ' Search result is empty')
            ->with('search_url', 'user/' . $username)
            ->with('scroll_url', 'user/' . $username);
    }

    public function searchByUsername(Request $request, $tag, $search)
    {
        $posts = (new User)->getPostsByUsername($tag)->withCount('comments')
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
            ->with('page_title', "User: {$tag}, Search: {$search}")
            ->with('search_url', "user/{$tag}")
            ->with('scroll_url', "user/{$tag}/search/{$search}");
    }

    public function scrollSearchByUsername($tag, $search, $skip)
    {
        $posts = (new User)->getPostsByUsername($tag)->withCount('comments')
            ->with('tags')
            ->where(function($query) use ($search){
                $query->where('name','like', '%'.$search.'%')
                    ->orWhere('text','like', '%'.$search.'%');
            })
            ->take(5)
            ->skip((int)$skip * 5)
            ->orderBy('created_at','desc')->get();

        return view('partials.scroll', ['posts' => $posts]);
    }


}
