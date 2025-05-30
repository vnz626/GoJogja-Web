<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - GoJogja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Poppins', 'sans-serif'],
            },
            colors: {
              'custom-blue': '#518EF8', 
              'overlay-blue': '#6DC3F5', // Warna ini akan kita gunakan
            }
          }
        }
      }
    </script>
    <style>
        body {
            background-image: url('/images/auth-background.jpg'); 
        }
    </style>
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center font-sans">
    <div class="absolute inset-0 bg-overlay-blue opacity-50"></div>

    <div class="relative z-10 w-full max-w-md bg-white bg-opacity-85 p-8 rounded-lg shadow-xl text-gray-800">
        <div class="text-center mb-8">
            <a href="/">
                <img src="/images/logo.png" alt="GoJogja Logo" class="h-16 mx-auto mb-4">
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h1>
            <p class="text-gray-600">Bergabunglah bersama kami!</p>
        </div>

        <form action="/register" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="w-full bg-gray-50 border border-gray-300 text-gray-900 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue @error('name') border-red-500 @enderror" placeholder="Nama Anda" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" class="w-full bg-gray-50 border border-gray-300 text-gray-900 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue @error('email') border-red-500 @enderror" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full bg-gray-50 border border-gray-300 text-gray-900 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue @error('password') border-red-500 @enderror" placeholder="•••••••• (Minimal 8 karakter)" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 text-gray-900 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-custom-blue text-white py-3 rounded-md font-bold hover:bg-blue-600 transition-transform transform hover:scale-105">Daftar</button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-8">
            Sudah punya akun? <a href="/login" class="text-custom-blue font-bold hover:underline">Login di sini</a>
        </p>
    </div>
</body>
</html>