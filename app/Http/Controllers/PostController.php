<?php

namespace App\Http\Controllers;

use App\Helpers\Nav;
use App\Post;
use App\Tag;
use App\Services\PostScrollService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    /**
     * @var PostScrollService
     */
    private $postScroll;

    /**
     * Create a new controller instance.
     *
     * @param PostScrollService $postScroll
     */
    public function __construct(PostScrollService $postScroll)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->postScroll = $postScroll;
    }

    /**
     * Display a listing Posts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->postScroll->scroll(\Auth::user()->posts());
        return view('home')->with('posts', $posts)
            ->with('page_title', 'Posts')
            ->with('search_url', 'posts')
            ->with('scroll_url', 'posts');
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::pluck('name', 'name');
        return view('posts.create')->with('tags', $tags)->with('page_title', 'Create post');
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
            'image' => 'max:10000|not_ext:php,exe',
        ]);

        $attributes = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            $fileName = str_random(10) . '.' . $file_ext;

            Storage::disk('local')->put(
                'public/' . auth()->id() . DIRECTORY_SEPARATOR . $fileName,
                File::get($file)
            );

            $attributes['image'] = $fileName;
        }

        // Store youtube id
        $attributes['youtube'] = Post::youtubeIdFromUrl($attributes['youtube']);

        if ($request->input('id')) {
            Post::find($request->input('id'))->update($attributes);
            $post = Post::find($request->input('id'));
        } else {
            $attributes = array_add($attributes,'user_id', auth()->id());
            $post = Post::create($attributes);
        }

        // Tags sync
        if ($request->has('tag_list')) {
            $tagLists = [];
            foreach ($request->input('tag_list') as $tag) {
                $tagLists[] = Tag::firstOrCreate(['name' => $tag])->id;
            }
            $post->tags()->sync($tagLists);
        } else {
            $post->tags()->detach();
        }

        return redirect('user/' . Auth::user()->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Auth::user()->posts()->findOrFail($id)->first();

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
        $post = Auth::user()->posts()->findOrFail($id)->first();
        if ($post) {
            $post->destroy($id);
            return back();
        } else {
            return abort('401', 'Unauthorized.');
        }
    }

    /**
     * Get posts own current user
     * @param $skip
     * @param $take
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function scroll( $skip )
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scroll(\Auth::user()->posts());
        return view('partials.scroll', ['posts' => $posts]);
    }

    public function searchRedirect(Request $request)
    {
        $search = $request->input('q');

        if (!empty($search)) {
            return redirect('posts/search/' . $search);
        }
        return view('empty')
            ->with('page_title', 'Posts, Search:  result is empty')
            ->with('search_url', "posts")
            ->with('scroll_url', "posts");
    }

    public function search($search)
    {
        $posts = $this->postScroll->scrollSearch((\Auth::user()->posts()), $search);
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "Posts, Search: {$search}")
            ->with('search_url', "posts")
            ->with('scroll_url', "posts/search/{$search}");
    }

    public function scrollSearch($search, $skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scrollSearch((\Auth::user()->posts()), $search);
        return view('partials.scroll', ['posts' => $posts]);
    }

    /**
     * Display the Post.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /**
         * FIXME: Строка ниже выдаете мне пустой $post->tags
         */
        // $post = Post::find($id)->with('tags')->first();
        /**
         * а следеющая выдает выдает нормальный, В чем проблема
         */
        $post = Post::whereId($id)->with('tags')->first();
        return view('theme.single_post',compact('post'))
            ->with('page_title', $post->name)
            ->with('search_url', 'home');
    }



    public function test()
    {
        //<iframe width="854" height="480" src="https://www.youtube.com/embed/Qjjqu8-MxHU" frameborder="0" allowfullscreen></iframe>
        $id = $this->youtube_id_from_url('https://www.youtube.com/watch?v=Qjjqu8-MxHU');
        $id2 = $this->youtube_id_from_url('https://www.youtube.com/embed/Qjjqu8-MxHU');
        dd($id, $id2);
    }

}
