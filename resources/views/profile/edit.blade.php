@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-x1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Profil</h1>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex flex-col items-center mb-6">
        <img class="w-32 h-32 rounded-full object-cover border-4 border-custom-blue mb-4" 
             id="profile_photo_preview"
             src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=518EF8&color=fff' }}" 
             alt="Foto Profil">
        <label for="profile_photo" class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
            Ganti Foto
        </label>
        <input type="file" name="profile_photo" id="profile_photo" class="hidden" onchange="document.getElementById('profile_photo_preview').src = window.URL.createObjectURL(this.files[0])">
         @error('profile_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" id="email" value="{{ Auth::user()->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" disabled>
        <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah.</p>
    </div>

    <div class="mb-4">
        <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
        <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('gender') border-red-500 @enderror">
            <option value="" {{ !old('gender', Auth::user()->gender) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
            <option value="Laki-laki" {{ old('gender', Auth::user()->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('gender', Auth::user()->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
         @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
        <label for="date_of_birth" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date_of_birth') border-red-500 @enderror">
        @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    
    <hr class="my-6 border-gray-300">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Ganti Password</h2>
    <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengganti password.</p>

    <div class="mb-4">
        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Password Saat Ini</label>
        <input type="password" name="current_password" id="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror" placeholder="Masukkan password Anda saat ini">
        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password Baru</label>
        <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter">
        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ketik ulang password baru Anda">
    </div>
    
    <div class="flex items-center justify-end gap-4 mt-8">
        <a href="{{ route('profile.show') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Batal
        </a>
        <button type="submit" class="bg-custom-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Simpan Perubahan
        </button>
    </div>
</form>
    </div>
</div>
@endsection