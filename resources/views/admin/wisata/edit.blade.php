@extends('layouts.admin')

{{-- @section('content')
<div class="container">
    <h1>Edit Destinasi Wisata</h1>
    <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Destinasi</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $destination->title) }}">
            @error('title')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $destination->description) }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Harga Tiket (Rp)</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $destination->price) }}">
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Jam Buka</label>
            <input type="time" name="open" class="form-control" value="{{ old('open', $destination->open) }}">
            @error('open')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Jam Tutup</label>
            <input type="time" name="close" class="form-control" value="{{ old('close', $destination->close) }}">
            @error('close')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Subkategori</label>
            <select name="subcategory_id" class="form-control">
                @foreach($subcategories as $sc)
                    <option value="{{ $sc->id }}" {{ old('subcategory_id', $destination->subcategory_id) == $sc->id ? 'selected' : '' }}>
                        {{ $sc->name }}
                    </option>
                @endforeach
            </select>
            @error('subcategory_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Kategori Utama</label>
            <select name="category" class="form-control">
                <option value="Destinasi Populer" {{ old('category', $destination->category) == 'Destinasi Populer' ? 'selected' : '' }}>Destinasi Populer</option>
                <option value="Paket Wisata" {{ old('category', $destination->category) == 'Paket Wisata' ? 'selected' : '' }}>Paket Wisata</option>
            </select>
            @error('category')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Gambar (boleh banyak):</label>
            <input type="file" name="images[]" class="form-control" multiple>
            @error('images')<div class="text-danger">{{ $message }}</div>@enderror
            @error('images.*')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection --}}

@section('content')
    <h1>Edit Destinasi Wisata</h1>
    <form action="{{ route('admin.wisata.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Destinasi</label>
            <input type="text" name="title" class="form-control" value="{{ $destination->title }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $destination->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Harga Tiket (Rp)</label>
            <input type="number" name="price" class="form-control" value="{{ $destination->price }}" required>
        </div>

        <div class="form-group">
            <label>Jam Buka</label>
            <input type="time" name="open_time" class="form-control" value="{{ $destination->open_time }}" required>
        </div>

        <div class="form-group">
            <label>Jam Tutup</label>
            <input type="time" name="close_time" class="form-control" value="{{ $destination->close_time }}" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $destination->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Subkategori</label>
            <select name="subcategory_id" class="form-control" required>
                @foreach ($subcategories as $sub)
                    <option value="{{ $sub->id }}" {{ $sub->id == $destination->subcategory_id ? 'selected' : '' }}>{{ $sub->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_popular" {{ $destination->is_popular ? 'checked' : '' }}> Destinasi Populer
            </label>
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini:</label>
            <div class="row">
                @foreach ($destination->images as $img)
                    <div class="col-md-3">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail" width="150">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>Ganti Gambar:</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
@endsection
