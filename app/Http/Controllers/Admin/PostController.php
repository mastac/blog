<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PostsDataTable;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PostsDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(PostsDataTable $dataTable)
    {
        return $dataTable->render('admin.posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('name', 'name');
        return view('admin.posts.create')->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
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

        $attributes = array_add($attributes, 'user_id', auth()->id());
        $post = Post::create($attributes);

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

        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);//->first();

        if ($post) {

            $tags = Tag::pluck('name', 'name');

            return view('admin.posts.edit', ['post' => $post, 'tags' => $tags])
                ->with('page_title', 'Edit post');
        } else {
            return abort('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'text' => 'required',
            'image' => 'max:10000|not_ext:php,exe',
        ]);

        $post = Post::find($id);

        $attributes = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            $fileName = str_random(10) . '.' . $file_ext;

            Storage::disk('local')->put(
                'public/' . $post->user_id . DIRECTORY_SEPARATOR . $fileName,
                File::get($file)
            );

            $attributes['image'] = $fileName;
        }

        // Store youtube id
        if ($request->hasFile('youtube')) {
            $attributes['youtube'] = $post->youtubeIdFromUrl($request->input('youtube'));
            if ($attributes['youtube'] === false) {
                $attributes['youtube'] = '';
            }
        }

        $post->update($attributes);

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

        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id)->first();
        if ($post) {
            $post->destroy($id);
            return back();
        } else {
            return abort('401', 'Unauthorized.');
        }
    }
}
