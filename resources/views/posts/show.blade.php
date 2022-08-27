@extends('layouts.app')

@section('title', $post->title)

@section('content')
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>    
<p>Added  {{ $post->created_at->diffForHumans() }}</p>

@if(now() ->diffInMinutes($post->created_at) < 5)
<div class="alert alert-info">New!</div>
@endif
@forelse ($post->comments as $comment)
<div><p>{{$comment->content }}</p>
<p class="text-muted"> added at {{ $comment->created_at->diffForHumans() }}</p></div>
@empty
<div><p>No comments yet</p></div>
@endforelse
@endsection