@extends('layouts.app')
@section('title', 'Daftar Blog')

@section('content')
    <div class="mb-4">
    <a href="{{ route('blogs.index') }}"
        class="px-4 py-2 {{ request()->routeIs('blogs.index') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Semua Blog</a>
    <a href="{{ route('blogs.create') }}"
        class="px-4 py-2 {{ request()->routeIs('blogs.create') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Buat Blog Anda</a>
    </div>

    <div class="space-y-4">
    @foreach($blogs as $blog)
        <div class="bg-white p-4 shadow rounded">
        <h2 class="text-xl font-bold mb-2">{{ $blog->title }}</h2>
        <p class="text-gray-600 mb-4">{{ Str::limit($blog->content, 100) }}</p>
        <a href="{{ route('blogs.show', $blog) }}" class="text-blue-500">Lihat Detail</a>
        </div>
    @endforeach
</div>
@endsection
