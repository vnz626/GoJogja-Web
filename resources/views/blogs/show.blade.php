@extends('layouts.app')
@section('title', $blog->title)


@section('content')
{{-- Hero Section --}}
<section class="relative py-32 flex items-center justify-center text-white">
    <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/blog-hero-bg.jpg');"></div>
    <div class="absolute inset-0 bg-overlay-blue opacity-60 z-1"></div>
    <div class="relative z-10 text-center p-4">
        <h1 class="text-5xl md:text-6xl font-bold mb-3 header-text-shadow">{{ $blog->title }}</h1>
        <p class="text-xl md:text-2xl max-w-2xl mx-auto header-text-shadow">
            {{ $blog->kategori }} - {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d F Y') }}
        </p>
    </div>
</section>

{{-- Konten --}}
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl flex flex-col lg:flex-row gap-8 mt-[-4rem] relative z-20">

        {{-- Konten Kiri --}}
        <div class="lg:w-2/3">
            {{-- Gambar Utama --}}
            @if($blog->images && $blog->images->count())
                <div class="mb-6 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ asset('storage/' . $blog->images->first()->filename) }}"
                         alt="Gambar Utama Blog"
                         class="w-full h-auto max-h-[450px] object-contain" id="mainBlogImage">
                </div>
            @endif

            {{-- Galeri Foto --}}
            @if($blog->images && $blog->images->count() > 1)
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Galeri Foto</h3>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                    @foreach($blog->images as $img)
                        <a href="{{ asset('storage/' . $img->filename) }}" data-fancybox="blog-gallery" class="block rounded-md overflow-hidden border hover:border-custom-blue transition">
                            <img src="{{ asset('storage/' . $img->filename) }}" alt="Foto Blog" class="w-full h-20 sm:h-24 object-cover">
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Video --}}
            @if($blog->video_path)
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Video</h3>
                <video controls class="w-full rounded shadow">
                    <source src="{{ asset('storage/' . $blog->video_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
            @endif

            {{-- Isi Konten --}}
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Isi Konten</h2>
            <article class="prose max-w-none text-gray-600 leading-relaxed mb-6">
                {!! nl2br(e($blog->content)) !!}
            </article>

            {{-- Tombol Edit --}}
            @auth
                @if(Auth::id() === $blog->user_id)
                    <a href="{{ route('blogs.edit', $blog) }}" class="inline-block bg-custom-blue text-white px-5 py-2 rounded hover:bg-blue-600 transition">
                        Edit Blog
                    </a>
                @endif
            @endauth
        </div>

        {{-- Sisi Kanan (Opsional: Info Blog, atau lainnya) --}}
        <div class="lg:w-1/3">
            <div class="sticky top-28 bg-gray-50 p-6 rounded-lg shadow-lg text-gray-800">
                <h3 class="text-xl font-bold mb-4">Info Blog</h3>
                <p><strong>Kategori:</strong> {{ ucfirst($blog->kategori) }}</p>
                <p><strong>Subkategori:</strong> {{ ucfirst($blog->subkategori) }}</p>
                <p><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d M Y') }}</p>
                <p><strong>Penulis:</strong> {{ $blog->user->name }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Lightbox --}}
@pushOnce('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endPushOnce

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Fancybox.bind("[data-fancybox^='blog-gallery']", {
            Thumbs: false,
            Toolbar: {
                display: ["zoom", "slideshow", "fullscreen", "download", "close"]
            },
        });
    });
</script>
@endPushOnce
@endsection
