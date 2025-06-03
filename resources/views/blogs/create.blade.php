@extends('layouts.app')
@section('title', 'Buat Blog')

@section('content')
{{-- tampilan section  --}}
    <section class="relative h-screen flex items-center justify-center text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/blog-hero-bg.jpg');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-60 z-1"></div>
        <div class="relative z-10 text-center p-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-3 header-text-shadow">Blog</h1>
            <p class="text-xl md:text-2xl max-w-2xl mx-auto header-text-shadow">
                Buat Blog Kamu Sendiri
            </p>
        </div>
    </section>

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

            <div  class="text-gray-700 py-12 bg-white rounded-lg shadow-md">
               <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    {{-- Judul --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required>
                    </div>

                    {{-- Isi Konten --}}
                    <div class="md:col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Konten</label>
                        <textarea name="content" id="content" rows="6" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required></textarea>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required>
                            <option value="">Pilih Kategori</option>
                            <option value="rental">Rental</option>
                            <option value="paket wisata">Paket Wisata</option>
                        </select>
                    </div>

                    {{-- Subkategori --}}
                    <div>
                        <label for="subkategori" class="block text-sm font-medium text-gray-700 mb-1">Subkategori</label>
                        <select name="subkategori" id="subkategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required>
                            <option value="">Pilih Subkategori</option>
                        </select>
                    </div>

                    {{-- Video --}}
                    <div class="md:col-span-2">
                        <label for="video" class="block text-sm font-medium text-gray-700 mb-1">Video (opsional, MP4/AVI)</label>
                        <input type="file" name="video" id="video" accept="video/*" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                    </div>

                    {{-- Gambar Multiple --}}
                    <div class="md:col-span-2">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar (bisa lebih dari satu)</label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                    </div>

                    {{-- Tombol --}}
                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="bg-green-500 text-white font-semibold px-6 py-3 rounded-md hover:bg-green-600 transition-colors">Simpan Blog</button>
                    </div>
                </form>

                <!-- Script untuk dropdown subkategori -->
                <script>
                    const subcategories = {
                        'rental': ['Motor', 'Mobil'],
                        'paket wisata': ['Parangtritis', 'Tugu', 'Merapi', 'Malioboro']
                    };

                    document.getElementById('kategori').addEventListener('change', function() {
                        let selected = this.value;
                        let subs = subcategories[selected] || [];
                        let subSelect = document.getElementById('subkategori');

                        // Hapus semua opsi lama
                        subSelect.innerHTML = '<option value="">Pilih Subkategori</option>';

                        // Tambahkan opsi baru
                        subs.forEach(function(sub) {
                            let opt = document.createElement('option');
                            opt.value = sub.toLowerCase();
                            opt.text = sub;
                            subSelect.add(opt);
                        });
                    });
                </script>
            </div>
        </div>
    </section>

@endsection
