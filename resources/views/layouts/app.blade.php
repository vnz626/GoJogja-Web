<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoJogja')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['Poppins', 'sans-serif'] },
            colors: {
              'custom-blue': '#518EF8',
              'overlay-blue': '#6DC3F5' // Warna ini akan dipakai header
            }
          }
        }
      }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white font-sans"> <div id="app">
        <header class="bg-overlay-blue shadow-md sticky top-0 z-20">
            <div class="container mx-auto flex justify-between items-center p-4 text-white">
                <a href="/">
                    <img src="/images/logo.png" alt="GoJogja Logo" class="h-12">
                </a>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="/" class="font-medium">Home</a>
                    <a href="{{ route('paket-wisata.index') }}" class="font-medium hover:text-gray-200">Wisata Jogja</a>
                    <a href="{{ route('rental.index') }}" class="font-medium">Rental Kendaraan</a>
                    <a href="{{ route('blog-wisata.index') }}" class="font-medium">Blog Wisata</a>
                </nav>
                <div class="flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 font-semibold focus:outline-none">
                                <span>Halo, {{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 text-gray-800" style="display: none;">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profil Saya</a>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="font-semibold hover:underline">Login</a>
                        <a href="/register" class="bg-white text-custom-blue font-semibold px-4 py-2 rounded-md hover:bg-gray-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="py-8">
            @yield('content')
        </main>

        {{--
        <footer class="bg-gray-200 text-center p-4 mt-auto">
            <p class="text-gray-600">&copy; {{ date('Y') }} GoJogja. All Rights Reserved.</p>
        </footer>
        --}}
    </div>
</body>
</html>
