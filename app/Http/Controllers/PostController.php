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
        $this->middleware('auth', ['except' => [
            'show', 'getPostByUserName', 'getPostToScroll', 'search'
        ]]);
    }

    /**
     * Display a listing of the Post by own user_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts =  \Auth::user()->posts()->withCount('comments')->orderBy('created_at','desc')->get();
        return view('posts.list')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('name', 'name');
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

        $this->validate($request, [
            'name' => 'required',
            'text' => 'required',
        ]);

        if ($request->input('id')) {
            Post::find($request->input('id'))->update($request->all());
            $post = Post::find($request->input('id'));
        } else {
            $attributes = array_add($request->all(),'user_id', auth()->id());
            $post = Post::create($attributes);
        }

        // Tags sync
        if ($request->has('tag_list')) {
            $tagLists = [];
            foreach ($request->input('tag_list') as $tag) {
                $tagLists[] = Tag::firstOrCreate(['name' => $tag])->id;
            }
            $post->tags()->sync($tagLists);
        }

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

            $tags = Tag::pluck('name', 'name');

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

    public function getPostToScroll($offset, $count)
    {
        $posts = Post::withCount('comments')->take($count)->skip($offset)->get();
        return view('partials.scroll', ['posts' => $posts]);
    }

    public function scroll($offset, $count, $entry, $param = '')
    {
//        switch ($entry) {
//            case 'user':
//
//                break;
//        }
//        // user
//        $posts = Post::whereHas('user',function($query) use ($param){
//            $query->where('users.name','=',$param);
//        })->take($count)->skip($offset)->get();

        // home
        $posts = Post::withCount('comments')->take($count)->skip($offset)->get();

        return view('partials.scroll', ['posts' => $posts]);
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        $posts = Post::withCount('comments')->where(function($query) use ($search){
            $query->where('name','like', '%'.$search.'%')
                ->orWhere('text','like', '%'.$search.'%');
        })->orderBy('created_at','desc')->get();
        return view('posts.list')->with('posts', $posts)->with('title_page', 'Search: ' . $search);
    }

    public function getPostByUserName($name)
    {
        $posts = Post::whereHas('user',function($query) use ($name){
             $query->where('users.name','=',$name);
        })->take(5)->get();

        return view('posts.list')->with('posts', $posts)->with('title_page', 'Posts of user ' . $name);
    }

}
