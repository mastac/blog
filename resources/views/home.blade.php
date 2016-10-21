@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @forelse($posts as $post)
                        <div style="margin: 20px;">
                            <h2><a href="{{url('post', $post->id)}}">{{$post->name}}</a></h2>
                            <div>{{$post->text}}</div>
                            <div>{{$post->user()->first()->first_name}} {{$post->user()->first()->last_name}}</div>
                            <div>{{$post->created_at}}</div>
                            <div>
                                @foreach($post->tags()->pluck('name','id')->toArray() as $tag)
                                    <a href="{{url('tag',$tag)}}">{{$tag}}</a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        Empty
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
