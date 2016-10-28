<?php

namespace App\Http\Controllers;

use App\Services\PostScrollService;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    /**
     * @var PostScrollService
     */
    private $postScroll;

    public function __construct(PostScrollService $postScroll)
    {
        $this->postScroll = $postScroll;
    }

    public function postByUsername($username)
    {
        $posts = $this->postScroll->scroll((new User)->getPostsByUsername($username));
        return view('home', ['posts' => $posts])
            ->with('page_title', 'User: '. $username)
            ->with('search_url', 'user/' . $username)
            ->with('scroll_url', 'user/' . $username);
    }

    public function scrollByUsername( $username, $skip )
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new User)->getPostsByUsername($username));
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
        $posts = $this->postScroll->scrollSearch((new User)->getPostsByUsername($tag), $search);
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "User: {$tag}, Search: {$search}")
            ->with('search_url', "user/{$tag}")
            ->with('scroll_url', "user/{$tag}/search/{$search}");
    }

    public function scrollSearchByUsername($tag, $search, $skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scrollSearch((new User)->getPostsByUsername($tag), $search);
        return view('partials.scroll', ['posts' => $posts]);
    }


}
