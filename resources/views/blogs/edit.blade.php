@extends('layouts.app')
@section('title', 'Edit Blog')

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

{{-- Form Edit Blog --}}
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-3xl">
                @include('blogs.partials.update-blog-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-3xl">
                <div class="mt-6">
                    @include('blogs.partials.delete-blog-form')
                </div>
            </div>
        </div>
        {{-- Tombol Kembali --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex justify-end">
                <a href="{{ route('blogs.show', $blog) }}" class="mt-6 w-full text-center bg-custom-blue text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Kembali ke Blog
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
