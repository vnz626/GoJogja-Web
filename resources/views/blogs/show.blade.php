@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ $blog->image_url ? asset('storage/' . $blog->image_url) : ($blog->images->first() ? asset('storage/' . $blog->images->first()->filename) : '/images/blog/default.jpg') }}');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20 text-center">
            <span class="inline-block bg-white text-custom-blue text-sm px-3 py-1 rounded-full uppercase font-semibold tracking-wide mb-4">{{ $blog->kategori }}</span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold header-text-shadow max-w-4xl mx-auto">{{ $blog->title }}</h1>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl flex flex-col lg:flex-row gap-8 mt-[-6rem] relative z-20">
            
            <div class="lg:w-2/3">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if($blog->image_url)
                    <div class="mb-8 rounded-lg overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $blog->image_url) }}" alt="{{ $blog->title }}" class="w-full h-auto max-h-[500px] object-contain">
                    </div>
                @endif
                
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi</h2>
                <article class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($blog->content)) !!}
                </article>

                @if($blog->video_path)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Video Terkait</h2>
                    <div class="rounded-lg overflow-hidden shadow-md">
                        <video controls class="w-full">
                            <source src="{{ asset('storage/' . $blog->video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                </div>
                @endif

                @if($blog->images && $blog->images->isNotEmpty())
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Galeri Foto</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($blog->images as $image)
                        <a href="{{ asset('storage/' . $image->filename) }}" data-fancybox="blog-gallery" class="block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                            <img src="{{ asset('storage/' . $image->filename) }}" alt="Galeri foto untuk {{ $blog->title }}" class="w-full h-40 object-cover">
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <aside class="lg:w-1/3">
                <div class="sticky top-28">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Info Blog</h2>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex"><span class="font-semibold w-28 flex-shrink-0">Kategori:</span><span>{{ $blog->kategori }}</span></div>
                            @if($blog->sub_kategori)<div class="flex"><span class="font-semibold w-28 flex-shrink-0">Subkategori:</span><span>{{ $blog->sub_kategori }}</span></div>@endif
                            <div class="flex"><span class="font-semibold w-28 flex-shrink-0">Dibuat:</span><span>{{ $blog->created_at->translatedFormat('d F Y') }}</span></div>
                            <div class="flex"><span class="font-semibold w-28 flex-shrink-0">Penulis:</span><a href="#" class="text-custom-blue hover:underline">{{ $blog->user->name ?? 'Tim GoJogja' }}</a></div>
                        </div>
                    </div>
                    @auth
                        @if(Auth::id() == $blog->user_id || (Auth::check() && optional(Auth::user())->is_admin))
                        <div class="mt-6 flex gap-4">
                            <a href="{{ route('blogs.edit', $blog) }}" class="flex-1 text-center bg-custom-blue text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Edit Blog</a>
                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="flex-1">@csrf @method('DELETE')<button type="submit" class="w-full text-center bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">Hapus</button></form>
                        </div>
                        @endif
                    @endauth
                </div>
            </aside>
        </div>
        <div class="text-center mt-12"><a href="{{ route('blogs.index') }}" class="w-full sm:w-auto inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition-colors">← Kembali ke Semua Blog</a></div>
    </div>
    @pushOnce('styles')<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />@endPushOnce
    @pushOnce('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>document.addEventListener('DOMContentLoaded', () => { Fancybox.bind("[data-fancybox='blog-gallery']", {}); });</script>
    @endPushOnce
@endsection