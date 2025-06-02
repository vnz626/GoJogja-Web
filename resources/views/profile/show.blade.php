@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-x1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Profil Saya</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col items-center">
            <img class="w-32 h-32 rounded-full object-cover border-4 border-custom-blue mb-4"
                 src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=518EF8&color=fff' }}"
                 alt="Foto Profil">

            <div class="w-full mt-6">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
                    <p class="text-gray-800 text-lg">{{ Auth::user()->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <p class="text-gray-800 text-lg">{{ Auth::user()->email }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</label>
                    <p class="text-gray-800 text-lg">{{ Auth::user()->gender ?? 'Belum diatur' }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir:</label>
                    <p class="text-gray-800 text-lg">{{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('d F Y') : 'Belum diatur' }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="mt-6 w-full text-center bg-custom-blue text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
