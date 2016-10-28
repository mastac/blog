<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostScrollService;
use App\Tag;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MyPostController extends Controller
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
        $this->middleware('auth');
        $this->postScroll = $postScroll;
    }

    /**
     * Display a listing of My Posts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->postScroll->scroll(\Auth::user()->posts());
        return view('home')->with('posts', $posts)
            ->with('page_title', 'My posts')
            ->with('search_url', 'myposts')
            ->with('scroll_url', 'myposts');
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

        return redirect('myposts');
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
            return redirect('myposts/search/' . $search);
        }
        return view('empty')
            ->with('page_title', 'My Posts, Search:  result is empty')
            ->with('search_url', "myposts")
            ->with('scroll_url', "myposts");
    }

    public function search($search)
    {
        $posts = $this->postScroll->scrollSearch((\Auth::user()->posts()), $search);
        return view('home')
            ->with('posts', $posts)
            ->with('page_title', "My Posts, Search: {$search}")
            ->with('search_url', "myposts")
            ->with('scroll_url', "myposts/search/{$search}");
    }

    public function scrollSearch($search, $skip)
    {
        $this->postScroll->setSkip($skip);
        $posts = $this->postScroll->scrollSearch((\Auth::user()->posts()), $search);
        return view('partials.scroll', ['posts' => $posts]);
    }

}
