@extends('layouts.app')

@section('title', 'Edit Artikel: ' . $blog->title)

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ $blog->image_url ? asset('storage/' . $blog->image_url) : ($blog->images->first() ? asset('storage/' . $blog->images->first()->filename) : '/images/blog/default.jpg') }}');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20">
            <h1 class="text-4xl sm:text-5xl font-bold header-text-shadow">Edit Blog</h1>
            <p class="text-lg md:text-xl text-gray-200 header-text-shadow mt-2 truncate">{{ $blog->title }}</p>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl max-w-4xl mx-auto mt-[-6rem] relative z-20">
            <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" value="{{ old('title', $blog->title) }}" required>
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Konten</label>
                    <textarea name="content" id="content" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kategori" class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required>
                            <option value="Destinasi Populer" {{ old('kategori', $blog->kategori) == 'Destinasi Populer' ? 'selected' : '' }}>Destinasi Populer</option>
                            <option value="Kuliner" {{ old('kategori', $blog->kategori) == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                            <option value="Budaya" {{ old('kategori', $blog->kategori) == 'Budaya' ? 'selected' : '' }}>Budaya</option>
                            <option value="Tips Perjalanan" {{ old('kategori', $blog->kategori) == 'Tips Perjalanan' ? 'selected' : '' }}>Tips Perjalanan</option>
                            <option value="Rental" {{ old('kategori', $blog->kategori) == 'Rental' ? 'selected' : '' }}>Info Rental</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="subkategori" class="block text-sm font-bold text-gray-700 mb-1">Subkategori (Opsional)</label>
                        <select name="subkategori" id="subkategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                            <option value="">Pilih Subkategori</option>
                        </select>
                    </div>
                </div>

                <hr class="my-2">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kelola Gambar</label>
                    @if($blog->images->isNotEmpty())
                        <p class="text-xs text-gray-500 mb-3">Centang gambar yang ingin Anda hapus.</p>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4 mb-4">
                            @foreach($blog->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->filename) }}" class="w-full h-24 object-cover rounded-md">
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" title="Pilih untuk hapus" class="h-6 w-6 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-3">Belum ada gambar galeri.</p>
                    @endif
                </div>

                <div>
                    <label for="images" class="block text-sm font-bold text-gray-700 mb-1">Tambah Gambar Baru (Opsional)</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kelola Video (Opsional)</label>
                    @if($blog->video_path)
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">Video saat ini:</p>
                            <video controls width="250" class="rounded-md mt-1"><source src="{{ asset('storage/' . $blog->video_path) }}"></video>
                            <div class="mt-2 flex items-center">
                                <input type="checkbox" name="remove_video" value="1" id="remove_video" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label for="remove_video" class="ml-2 text-sm text-gray-600">Hapus video ini</label>
                            </div>
                        </div>
                    @endif
                    <label for="video" class="block text-xs text-gray-500 mb-1">{{ $blog->video_path ? 'Ganti dengan video baru:' : 'Upload video baru:' }}</label>
                    <input type="file" name="video" id="video" accept="video/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                </div>
                
                <div class="flex justify-end pt-6 gap-4 border-t mt-6">
                    <a href="{{ route('blogs.show', $blog) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md transition-colors">Batal</a>
                    <button type="submit" class="bg-custom-blue hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">Update Blog</button>
                </div>
            </form>

            <div class="border-t mt-10 pt-6">
                <h3 class="text-lg font-bold text-red-600">Hapus Blog</h3>
                <p class="text-sm text-gray-600 mt-1">Setelah blog dihapus, semua data terkait termasuk gambar dan video akan hilang permanen. Aksi ini tidak dapat dibatalkan.</p>
                <div class="mt-4">
                     <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS BLOG INI SECARA PERMANEN?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition-colors">
                            Ya, Hapus Artikel Ini
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriDropdown = document.getElementById('kategori');
        const subkategoriDropdown = document.getElementById('subkategori');
        
        const currentKategori = "{{ old('kategori', $blog->kategori) }}";
        const currentSubkategori = "{{ old('subkategori', $blog->subkategori) }}";

        const subkategoriData = {
            'Destinasi Populer': ['Pantai', 'Candi', 'Gunung', 'Air Terjun', 'Museum'],
            'Kuliner': ['Kaki Lima', 'Restoran', 'Kafe', 'Jajanan Tradisional'],
            'Budaya': ['Seni Pertunjukan', 'Kerajinan', 'Upacara Adat'],
            'Tips Perjalanan': ['Backpacking', 'Liburan Keluarga', 'Solo Traveling'],
            'Rental': ['Mobil', 'Motor']
        };

        function updateSubkategori(selectedKategori) {
            subkategoriDropdown.innerHTML = '<option value="">Pilih Subkategori</option>';

            if (selectedKategori && subkategoriData[selectedKategori]) {
                const options = subkategoriData[selectedKategori];
                options.forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item;
                    option.innerText = item;
                    if (item === currentSubkategori) {
                        option.selected = true;
                    }
                    subkategoriDropdown.appendChild(option);
                });
                subkategoriDropdown.disabled = false;
            } else {
                subkategoriDropdown.disabled = true;
            }
        }

        kategoriDropdown.addEventListener('change', function() {
            // Saat kategori diubah, reset nilai subkategori tersimpan agar tidak salah pilih
            // Anda bisa hapus baris ini jika tidak ingin subkategori ter-reset
            // currentSubkategori = ''; 
            updateSubkategori(this.value);
        });
        
        // Panggil fungsi saat halaman pertama kali dimuat
        // untuk mengisi subkategori berdasarkan kategori yang sudah ada
        if (kategoriDropdown.value) {
            updateSubkategori(kategoriDropdown.value);
        }
    });
</script>
@endpush