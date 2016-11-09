<?php

namespace App\Http\Controllers;

use App\Helpers\Nav;
use App\Post;
use App\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'test']]);
    }

    /**
     * Display a listing Posts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = \Auth::user()->posts()->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip(0)
            ->orderBy('created_at','desc')->get();

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
        return view('posts.create')->with('tags', $tags)
            ->with('page_title', 'Create post');
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

        if ($request->input('id')) {
            Post::find($request->input('id'))->update($attributes);
            $post = Post::find($request->input('id'));
        } else {
            $attributes = array_add($attributes, 'user_id', auth()->id());
            $post = Post::create($attributes);
        }

        // Store youtube id
        $attributes['youtube'] = $post->youtubeIdFromUrl($attributes['youtube']);
        if ($attributes['youtube'] === false) {
            $attributes['youtube'] = '';
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
        $post = Auth::user()->posts()->find($id);//->first();

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
        $posts = \Auth::user()->posts()->withCount('comments')
            ->with('tags')
            ->take(5)
            ->skip((int) $skip * 5)
            ->orderBy('created_at','desc')->get();

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
        $posts = \Auth::user()->posts()->withCount('comments')
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
            ->with('page_title', "Posts, Search: {$search}")
            ->with('search_url', "posts")
            ->with('scroll_url', "posts/search/{$search}");
    }

    public function scrollSearch($search, $skip)
    {
        $posts = \Auth::user()->posts()->withCount('comments')
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

    /**
     * Display the Post.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::with('tags')->find($id);

        return view('theme.single_post',compact('post'))
            ->with('page_title', $post->name)
            ->with('search_url', 'home');
    }


    public function test()
    {
        //<iframe width="854" height="480" src="https://www.youtube.com/embed/Qjjqu8-MxHU" frameborder="0" allowfullscreen></iframe>
//        $id = $this->youtube_id_from_url('https://www.youtube.com/watch?v=Qjjqu8-MxHU');
//        $id2 = $this->youtube_id_from_url('https://www.youtube.com/embed/Qjjqu8-MxHU');
//        dd($id, $id2);
//        $s = \Auth::user()->posts()->save(['name' => 'test', 'text' => 'demo text']);
//        $s = factory(\App\Post::class)->create(['user_id' => '1']);
//        Auth::loginUsingId(1);
//        return redirect("/");
    }

}
