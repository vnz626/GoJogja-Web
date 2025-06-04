@extends('layouts.admin')

@section('content')
<h1>Tambah Destinasi Wisata</h1>
<form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Nama Destinasi</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>Harga Tiket (Rp)</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Jam Buka</label>
        <input type="time" name="open_time" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Jam Tutup</label>
        <input type="time" name="close_time" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <select name="category_id" id= "category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="rental">Rental</option>
            <option value="paket wisata">Paket Wisata</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Subkategori</label>
        <select name="subcategory_id" id="subcategory_id" class="form-control" required>
            <option value="">-- Pilih Subkategori --</option>
            @foreach ($subcategories as $sub)
                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="is_popular"> Destinasi Populer
        </label>
    </div>

    <div class="form-group">
        <label>Gambar (boleh banyak):</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
