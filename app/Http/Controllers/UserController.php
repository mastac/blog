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

    public function scroll( $username, $skip )
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll((new User)->getPostsByUsername($username));
        return view('partials.scroll', ['posts' => $posts]);
    }
}
