{{-- @extends('layouts.app')
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
@endsection --}}

<!-- File: resources/views/blogs/index.blade.php -->
@extends('layouts.app')
@section('title', 'Daftar Blog')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between">
    <div>
        <a href="{{ route('blogs.index') }}" class="px-4 py-2 {{ request()->routeIs('blogs.index') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded">Semua Blog</a>
        <a href="{{ route('blogs.create') }}" class="px-4 py-2 {{ request()->routeIs('blogs.create') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded">Buat Blog Anda</a>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Sort Dropdown -->
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700">Sort</label>
            <select id="sort" name="sort" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md">
                <option value="popular">Terpopuler</option>
                <option value="newest">Terbaru</option>
                <option value="cheapest">Termurah</option>
                <option value="best">Terbaik</option>
            </select>
        </div>

        <!-- Category Dropdown -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="category" name="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md">
                <option value="rental">Rental</option>
                <option value="destinasi">Destinasi Wisata</option>
                <option value="paket">Paket Wisata</option>
            </select>
        </div>

        <!-- Sub-Category Dropdown -->
        <div>
            <label for="subcategory" class="block text-sm font-medium text-gray-700">Sub Kategori</label>
            <select id="subcategory" name="subcategory" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md">
                <!-- Dynamic options by JS -->
            </select>
        </div>
    </div>
</div>

<!-- Blog Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($blogs as $blog)
        <div class="bg-white rounded shadow hover:shadow-lg transition duration-300">
            <img src="{{ asset('storage/blog_images/' . $blog->foto) }}" alt="Cover" class="w-full h-48 object-cover rounded-t">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-2">{{ $blog->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($blog->content, 100) }}</p>
                <a href="{{ route('blogs.show', $blog) }}" class="text-blue-500 hover:underline">Lihat Detail</a>
            </div>
        </div>
    @endforeach
</div>

<!-- Tambahkan JavaScript untuk dinamis sub-kategori -->
<script>
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');

    const subcategories = {
        rental: ['Motor', 'Mobil', 'Bajaj', 'Lainnya'],
        destinasi: ['Candi', 'Area Belanja', 'Taman Wisata', 'Pantai'],
        paket: ['Alam', 'Perkotaan', 'Campuran']
    };

    categorySelect.addEventListener('change', function () {
        const selected = this.value;
        const options = subcategories[selected] || [];

        subcategorySelect.innerHTML = '';
        options.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.toLowerCase();
            option.textContent = sub;
            subcategorySelect.appendChild(option);
        });
    });
</script>
@endsection
