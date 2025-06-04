@extends('layouts.admin')

@section('content')
    <h1>Daftar Destinasi Wisata</h1>
    <a href="{{ route('admin.wisata.create') }}" class="btn btn-primary">Tambah Destinasi</a>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Subkategori</th>
                <th>Harga</th>
                <th>Jam Operasional</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($destinations as $destination)
                <tr>
                    <td>{{ $destination->title }}</td>
                    <td>{{ $destination->category->name ?? '-' }}</td>
                    <td>{{ $destination->subcategory->name ?? '-' }}</td>
                    <td>Rp{{ number_format($destination->price) }}</td>
                    <td>{{ $destination->open_time }} - {{ $destination->close_time }}</td>
                    <td>
                        <a href="{{ route('admin.wisata.edit', $destination->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.wisata.destroy', $destination->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
