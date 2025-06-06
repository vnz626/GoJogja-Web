@extends('layouts.app')

@section('title', 'Tulis Artikel Blog Baru')

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/blog-hero-bg.jpg');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20">
            <h1 class="text-4xl sm:text-5xl font-bold header-text-shadow">Tulis Artikel Baru</h1>
            <p class="text-lg md:text-xl text-gray-200 header-text-shadow mt-2">Bagikan cerita dan pengalamanmu tentang Yogyakarta.</p>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl max-w-4xl mx-auto mt-[-6rem] relative z-20">
            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" value="{{ old('title') }}" required placeholder="Contoh: 5 Tips Liburan Hemat di Jogja">
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Konten</label>
                    <textarea name="content" id="content" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" rows="10" required placeholder="Tulis ceritamu di sini...">{{ old('content') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kategori" class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Destinasi Populer">Destinasi Populer</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Budaya">Budaya</option>
                            <option value="Tips Perjalanan">Tips Perjalanan</option>
                            <option value="Rental">Info Rental</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="subkategori" class="block text-sm font-bold text-gray-700 mb-1">Subkategori (Opsional)</label>
                        <select name="subkategori" id="subkategori" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" disabled>
                            <option value="">Pilih Kategori Terlebih Dahulu</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Upload Gambar (bisa lebih dari satu, gambar pertama akan menjadi thumbnail)</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Video (Opsional)</label>
                    <input type="file" name="video" id="video" accept="video/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                </div>

                <div class="flex justify-end pt-4 gap-4">
                    <a href="{{ route('blogs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md transition-colors">Batal</a>
                    <button type="submit" class="bg-custom-blue hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">Simpan Blog</button>
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
        
        const oldKategori = "{{ old('kategori') }}";
        const oldSubkategori = "{{ old('subkategori') }}";

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
                    if (item === oldSubkategori) {
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

        if (kategoriDropdown.value) {
            updateSubkategori(kategoriDropdown.value);
        } else if (oldKategori) {
            kategoriDropdown.value = oldKategori;
            updateSubkategori(oldKategori);
        }

        kategoriDropdown.addEventListener('change', function() {
            updateSubkategori(this.value);
        });
    });
</script>
@endpush