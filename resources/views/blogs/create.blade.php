@extends('layouts.app')
@section('title', 'Buat Blog')

@section('content')
<form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Title -->
    <div class="mb-4">
        <label class="block mb-1">Judul</label>
        <input type="text" name="title" class="w-full border px-3 py-2" required>
    </div>
    <!-- Content -->
    <div class="mb-4">
        <label class="block mb-1">Isi Konten</label>
        <textarea name="content" class="w-full border px-3 py-2" rows="5" required></textarea>
    </div>
    <!-- Kategori -->
    <div class="mb-4">
        <label class="block mb-1">Kategori</label>
        <select name="kategori" id="kategori" class="w-full border px-3 py-2" required>
        <option value="">Pilih Kategori</option>
        <option value="rental">Rental</option>
        <option value="paket wisata">Paket Wisata</option>
        </select>
    </div>
    <!-- Subkategori (diisi dinamis via JS) -->
    <div class="mb-4">
        <label class="block mb-1">Subkategori</label>
        <select name="subkategori" id="subkategori" class="w-full border px-3 py-2" required>
        <option value="">Pilih Subkategori</option>
        <!-- opsi akan diisi dengan JavaScript berdasarkan kategori -->
        </select>
    </div>
    <!-- Video -->
    <div class="mb-4">
        <label class="block mb-1">Video (opsional, MP4/AVI)</label>
        <input type="file" name="video" accept="video/*" class="w-full">
    </div>
    <!-- Gambar Multiple -->
    <div class="mb-4">
        <label class="block mb-1">Upload Gambar (bisa lebih dari satu)</label>
        <input type="file" name="images[]" accept="image/*" multiple class="w-full">
    </div>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan Blog</button>
    </form>

    <!-- Script untuk dropdown subkategori -->
    <script>
    const subcategories = {
        'rental': ['Motor', 'Mobil'],
        'paket wisata': ['Parangtritis', 'Tugu', 'Merapi', 'Malioboro']
    };
    document.getElementById('kategori').addEventListener('change', function() {
        let subs = subcategories[this.value] || [];
        let subEl = document.getElementById('subkategori');
        subEl.innerHTML = '<option value=\"\">Pilih Subkategori</option>';
        subs.forEach(s => {
        let opt = document.createElement('option');
        opt.value = s.toLowerCase();
        opt.text = s;
        subEl.add(opt);
        });
    });
</script>
@endsection
