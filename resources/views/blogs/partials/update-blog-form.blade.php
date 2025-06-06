@extends('layouts.app')

@section('title', 'Edit Artikel: ' . $blog->title)

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ $blog->image_url ? asset('storage/' . $blog->image_url) : ($blog->images->first() ? asset('storage/' . $blog->images->first()->filename) : '/images/blog/default.jpg') }}');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20">
            <h1 class="text-4xl sm:text-5xl font-bold header-text-shadow">Edit Artikel</h1>
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
                    <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue @error('title') border-red-500 @enderror" value="{{ old('title', $blog->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Konten</label>
                    <textarea name="content" id="content" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue @error('content') border-red-500 @enderror" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kategori" class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue @error('kategori') border-red-500 @enderror" required>
                            <option value="" disabled>Pilih Kategori</option>
                            <option value="Destinasi Populer" {{ old('kategori', $blog->kategori) == 'Destinasi Populer' ? 'selected' : '' }}>Destinasi Populer</option>
                            <option value="Kuliner" {{ old('kategori', $blog->kategori) == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                            <option value="Budaya" {{ old('kategori', $blog->kategori) == 'Budaya' ? 'selected' : '' }}>Budaya</option>
                            <option value="Tips Perjalanan" {{ old('kategori', $blog->kategori) == 'Tips Perjalanan' ? 'selected' : '' }}>Tips Perjalanan</option>
                            <option value="Rental" {{ old('kategori', $blog->kategori) == 'Rental' ? 'selected' : '' }}>Info Rental</option>
                        </select>
                        @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="subkategori" class="block text-sm font-bold text-gray-700 mb-1">Subkategori (Opsional)</label>
                        <select name="subkategori" id="subkategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue @error('subkategori') border-red-500 @enderror">
                            <option value="">Pilih Subkategori</option>
                        </select>
                         @error('subkategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Gambar Utama / Thumbnail (Opsional)</label>
                    <input type="file" name="image_utama" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    @error('image_utama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tambah Gambar Galeri (Opsional)</label>
                    <input type="file" name="images[]" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Video (Opsional)</label>
                    <input type="file" name="video" accept="video/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    @error('video') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-4 gap-4">
                    <a href="{{ route('blogs.show', $blog) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md transition-colors">Batal</a>
                    <button type="submit" class="bg-custom-blue hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">Update Blog</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriDropdown = document.getElementById('kategori');
        const subkategoriDropdown = document.getElementById('subkategori');
        
        // Ambil nilai kategori dan subkategori yang tersimpan di database
        const currentKategori = "{{ old('kategori', $blog->kategori) }}";
        const currentSubkategori = "{{ old('subkategori', $blog->sub_kategori) }}";

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
                    // Pilih subkategori yang sesuai dengan data yang tersimpan
                    if (item === currentSubkategori) {
                        option.selected = true;
                    }
                    subkategoriDropdown.appendChild(option);
                });
                subkategoriDropdown.disabled = false;
            } else {
                subkategoriDropdown.disabled = true;
                subkategoriDropdown.innerHTML = '<option value="">Pilih Kategori Terlebih Dahulu</option>';
            }
        }
        
        // Set nilai awal dropdown kategori dan panggil fungsi updateSubkategori
        if (currentKategori) {
            kategoriDropdown.value = currentKategori;
            updateSubkategori(currentKategori);
        }

        // Tambahkan event listener saat kategori berubah
        kategoriDropdown.addEventListener('change', function() {
            updateSubkategori(this.value);
            // Saat kategori utama diubah, subkategori yang tersimpan tidak lagi relevan, jadi kosongkan
            // Anda bisa hapus baris ini jika ingin subkategori tetap terpilih
            subkategoriDropdown.querySelector('option[value=""]').selected = true;
        });
    });
</script>
@endpush