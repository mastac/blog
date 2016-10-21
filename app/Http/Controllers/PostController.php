<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Post by own user_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::whereUserId(\Auth::id())->orderBy('created_at','desc')->get();
        return view('posts.list')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('name', 'id');
        return view('posts.create')->with('tags', $tags);
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes = $request->only(['name', 'text']);

        if ($request->input('id')) {
            Post::find($request->input('id'))->update($attributes);
            $post = Post::find($request->input('id'));
        } else {
            $attributes = array_add($attributes,'user_id', auth()->id());
            $post = Post::create($attributes);
        }

        // Tags sync
        $post->tags()->sync($request->input('tag_list'));

        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        $comments = $post->comments;

        return view('posts.show',compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Post::whereId($id)->whereUserId(auth()->id())->first();

        if ($post) {

            $tags = Tag::pluck('name', 'id');

            return view('posts.edit', ['post' => $post, 'tags' => $tags]);
        } else {
            return abort('401', 'Unauthorized.');
        }
    }


    /**
     * Delete post
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $post->destroy($id);
            return back();
        } else {
            return abort('401', 'Unauthorized.');
        }
    }

    public function test()
    {
        //
    }

}
