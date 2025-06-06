@extends('layouts.app')

@section('title', 'Blog Wisata - GoJogja')

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/blog-hero-bg.jpg');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20 text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold header-text-shadow">Blog Wisata GoJogja</h1>
            <p class="text-xl md:text-2xl text-gray-200 header-text-shadow mt-2 max-w-3xl mx-auto">Temukan inspirasi, tips, dan cerita menarik seputar destinasi dan kuliner di Yogyakarta.</p>
        </div>
    </section>

    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            
            @if (Auth::check())
                <div class="mb-8 text-right">
                    <a href="{{ route('blogs.create') }}" class="bg-custom-blue text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                        + Tulis Artikel Baru
                    </a>
                </div>
            @endif

            <form method="GET" action="{{ route('blogs.index') }}" id="filterForm" class="bg-white p-6 rounded-lg shadow-md mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Artikel</label>
                        <input type="text" name="search" id="search" value="{{ $searchTerm ?? '' }}" placeholder="Judul atau isi konten..." class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                    </div>
                    <div>
                        <label for="filter_category" class="block text-sm font-medium text-gray-700 mb-1">Filter Kategori</label>
                        <select name="filter_category" id="filter_category" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                            <option value="semua" {{ !$currentCategory || $currentCategory == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ $currentCategory == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-custom-blue text-white font-semibold px-6 py-2.5 rounded-md hover:bg-blue-700 transition-colors">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>

            @if($blogs->isEmpty())
                <div class="text-center py-20 bg-white rounded-lg shadow">
                    <p class="text-2xl text-gray-500">Oops! Tidak ada artikel ditemukan.</p>
                    <p class="text-gray-400 mt-2">Coba dengan kata kunci atau filter yang berbeda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($blogs as $blog)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col">
                            <a href="{{ route('blogs.show', $blog) }}">
                                <img src="{{ $blog->images->first() ? asset('storage/' . $blog->images->first()->filename) : '/images/blog/default.jpg' }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover">
                            </a>
                            <div class="p-5 flex flex-col flex-grow">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide mb-3 self-start">{{ $blog->kategori }}</span>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight hover:text-custom-blue transition-colors">
                                    <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                                <div class="mt-auto border-t pt-3 flex items-center justify-between text-xs text-gray-500">
                                    <span>Oleh: {{ $blog->user->name ?? 'Tim GoJogja' }}</span>
                                    <span>{{ $blog->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $blogs->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection