<!-- resources/views/blog/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Konten Utama -->
        <div class="md:col-span-2">
            <h1 class="text-3xl font-bold mb-6">Blog Wisata</h1>
            <p class="text-gray-700 mb-4">Temukan artikel menarik tentang wisata, tips perjalanan, dan destinasi terbaik.</p>
            {{-- <form action="{{ route('blog.search') }}" method="GET" class="mb-6">
                <input type="text" name="query" placeholder="Cari artikel..." class="w-full p-2 border rounded">
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
            </form> --}}
        </div>
        <!-- Sidebar Artikel Terbaru -->
        <div class="md:col-span-2">
            <h2 class="text-2xl font-bold mb-4">Artikel Terbaru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($blogs as $blog)
                <!-- Kartu Artikel -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $blog->title }}</h3>
                    <p class="text-gray-600">{{ Str::limit($blog->excerpt, 100) }}</p>
                    <a href="{{ route('blog.show', $blog) }}" class="text-blue-500 mt-2 block">Baca Selengkapnya</a>
                </div>
                </div>
            @endforeach
            </div>
        </div>
        <!-- Sidebar Trending -->
        <div>
            <h2 class="text-2xl font-bold mb-4">Trending</h2>
            <ul>
            {{-- @foreach($trendingPosts as $blog)
                <li class="mb-4">
                <a href="{{ route('blog.show', $blog) }}" class="block overflow-hidden rounded-lg">
                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-24 object-cover">
                    <p class="text-sm font-medium mt-2">{{ $blog->title }}</p>
                </a>
                </li>
            @endforeach --}}
            </ul>
        </div>
        </div>
        <!-- Section Tips & Tricks -->
        <section class="mt-8 bg-gray-100 p-6 rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Tips & Tricks</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold">Tips Pertama</h3>
            <p class="text-gray-600">Deskripsi singkat tips pertama.</p>
            </div>
            <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold">Tips Kedua</h3>
            <p class="text-gray-600">Deskripsi singkat tips kedua.</p>
            </div>
        </div>
        </section>
    </div>
    <footer class="bg-gray-900 text-white py-6 mt-10">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <h3 class="font-bold mb-2">Tentang Kami</h3>
            <p class="text-sm">Deskripsi singkat tentang perusahaan atau blog.</p>
        </div>
        <div>
            <h3 class="font-bold mb-2">Navigasi</h3>
            <ul class="text-sm space-y-1">
            <li><a href="/" class="hover:underline">Beranda</a></li>
            <li><a href="/blog" class="hover:underline">Blog</a></li>
            <li><a href="/about" class="hover:underline">Tentang</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-2">Newsletter</h3>
            <form action="#" method="POST" class="mt-2">
            <input type="email" name="email" placeholder="Email Anda" class="w-full p-2 rounded text-gray-800" required>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 rounded">Daftar</button>
            </form>
        </div>
    </div>
</footer>
@endsection
