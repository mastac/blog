<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CommentsDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CommentsDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CommentsDataTable $dataTable)
    {
        return $dataTable->render('admin.comments', ['page_title'=>'Comments', 'page_subtitle' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = \App\Post::all()->pluck('name', 'id')->map(function($item, $key){
            return str_limit($item, 100);
        });

        return view('admin.comments.create')
            ->with('posts', $posts)
            ->with('page_title', 'Comments')
            ->with('page_subtitle', 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\Comment::create($request->all());
        return redirect('/admin/comments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = \App\Comment::find($id);
        return view('admin.comments.show')
            ->with('comment', $comment)
            ->with('page_title', 'Comments')
            ->with('page_subtitle', 'show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = \App\Post::all()->pluck('name', 'id')->map(function($item, $key){
            return str_limit($item, 100);
        });

        $comment = \App\Comment::find($id);
        return view('admin.comments.edit')->with('posts', $posts)->with('comment', $comment)
            ->with('page_title', 'Comments')
            ->with('page_subtitle', 'edit');
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
        $comment = \App\Comment::find($id);
        $comment->update($request->all());

        return redirect('/admin/comments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Comment::destroy($id);
        return redirect('/admin/comments');
    }
}
