@extends('layouts.app')

@section('title', 'Blog Wisata GoJogja')

@section('content')
    {{-- tampilan section  --}}
    <section class="relative h-screen flex items-center justify-center text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/blog-hero-bg.jpg');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-60 z-1"></div>
        <div class="relative z-10 text-center p-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-3 header-text-shadow">Blog</h1>
            <p class="text-xl md:text-2xl max-w-2xl mx-auto header-text-shadow">
                Temukan Blog Terbaru
            </p>
        </div>
    </section>

    {{-- section search --}}
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('blogs.index') }}" id="filterForm" class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-3 lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ $searchTerm ?? '' }}" placeholder="Cari judul atau isi artikel..." class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                </div>

                <div>
                    <label for="filter_category" class="block text-sm font-medium text-gray-700 mb-1">Filter Kategori</label>
                    <select name="filter_category" id="filter_category" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                        <option value="semua" {{ !($currentCategory ?? null) || ($currentCategory ?? null) == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ ($currentCategory ?? null) == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort_by" id="sort_by" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                        <option value="terbaru" {{ (!($currentSortBy ?? null) || ($currentSortBy ?? null) == 'terbaru') ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ ($currentSortBy ?? null) == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="judul_az" {{ ($currentSortBy ?? null) == 'judul_az' ? 'selected' : '' }}>Judul A-Z</option>
                        <option value="judul_za" {{ ($currentSortBy ?? null) == 'judul_za' ? 'selected' : '' }}>Judul Z-A</option>
                    </select>
                </div>

                <div class="md:col-span-3 lg:col-span-4 mt-4 text-right">
                     <button type="submit" class="bg-custom-blue text-white font-semibold px-8 py-3 rounded-md hover:bg-blue-700 transition-colors">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- section daftar blog --}}
    <section class="bg-gray-100 pt-4 pb-12">
        <div class="container mx-auto px-4">
            <div class="mb-8 flex flex-wrap">
                @auth
                <a href="{{ route('blogs.index', ['user_articles' => Auth::id()]) }}"
                   class="px-5 py-3 font-semibold whitespace-nowrap
                          {{ request('user_articles') == Auth::id() ? 'border-b-2 border-custom-blue text-custom-blue' : 'text-gray-500 hover:text-custom-blue hover:border-custom-blue hover:border-b-2' }}">
                    Artikel Saya
                </a>
                <a href="{{ route('blogs.create') }}"
                   class="px-5 py-3 font-semibold whitespace-nowrap
                          {{ request()->routeIs('blogs.create') ? 'border-b-2 border-custom-blue text-custom-blue' : 'text-gray-500 hover:text-custom-blue hover:border-custom-blue hover:border-b-2' }}">
                    Tulis Artikel Baru
                </a>
                @endauth
            </div>

            {{-- Jika tidak ada blog yang ditemukan --}}
            @if(!isset($blogs) || $blogs->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-xl text-gray-500">Belum ada artikel blog yang cocok.</p>
                    <p class="text-gray-400 mt-2">Coba ubah filter atau kata kunci pencarian Anda.</p>
                </div>
            @else
                {{-- Jika ada blog yang ditemukan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($blogs as $blog)
                        <article class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col">
                            {{-- Thumbnail --}}
                            <a href="{{ route('blogs.show', $blog) }}">
                                @if($blog->video)
                                    <video controls class="w-full rounded shadow" poster="{{ asset('images/video-thumbnail.jpg') }}">
                                        <source src="{{ asset('storage/' . $blog->video) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                @elseif($blog->images && $blog->images->first())
                                    <img src="{{ asset('storage/' . $blog->images->first()->filename) }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover">
                                @else
                                    <img src="/images/blog/default.jpg" alt="{{ $blog->title }}" class="w-full h-56 object-cover">
                                @endif
                            </a>
                            {{-- Konten --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="mb-3">
                                    <span class="inline-block bg-custom-blue text-white text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">{{ $blog->kategori }}</span>
                                    <span class="ml-2 text-xs text-gray-500">{{ \Carbon\Carbon::parse(isset($blog->created_at) ? $blog->created_at : $blog->date )->format('d F Y') }}</span>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 mb-2">
                                    <a href="{{ route('blogs.show', $blog) }}" class="hover:text-custom-blue transition-colors">{{ $blog->title }}</a>
                                </h2>
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">{{ Str::limit($blog->content, 120) }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('blogs.show', $blog) }}" class="inline-flex items-center text-custom-blue font-semibold hover:underline">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    @if(isset($blogs) && method_exists($blogs, 'links'))
                        {{ $blogs->appends(request()->query())->links() }}
                    @endif
                </div>
            @endif
        </div>
    </section>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const scrollPositionKey = 'scrollPosition-' + window.location.pathname;

        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                sessionStorage.setItem(scrollPositionKey, window.scrollY);
            });
        }

        const storedScrollPosition = sessionStorage.getItem(scrollPositionKey);
        if (storedScrollPosition) {
            setTimeout(() => {
                window.scrollTo(0, parseInt(storedScrollPosition, 10));
                sessionStorage.removeItem(scrollPositionKey);Add commentMore actions
            }, 20);
        }
    });
</script>
