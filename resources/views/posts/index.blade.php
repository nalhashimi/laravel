@extends('layouts.app')

@section('title', 'Posts Index')

@section('content')
    @forelse ($posts as $key => $post)
       @include('posts.partials.post')   
    @empty
        <div>No post found!</div>
    @endforelse
@endsection