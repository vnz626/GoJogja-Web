@extends('layouts.app')
@section('title', $blog->title)

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $blog->title }}</h1>
<p class="text-gray-700 mb-6">{{ $blog->content }}</p>

@if($blog->video_path)
    <div class="mb-6">
        <video controls class="w-full">
        <source src="{{ asset('storage/' . $blog->video_path) }}">
        Browser Anda tidak mendukung video.
        </video>
    </div>
    @endif

    <div class="grid grid-cols-3 gap-4">
    @foreach($blog->images as $img)
        <img src="{{ asset('storage/' . $img->filename) }}" class="w-full rounded shadow">
    @endforeach
</div>

<a href="{{ route('blogs.edit', $blog) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Edit Blog</a>
@endsection
