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
              'overlay-blue': '#6DC3F5'
            }
          }
        }
      }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .header-text-shadow {
            text-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans">
    <div id="app" class="flex flex-col min-h-screen">
        <header class="absolute top-0 left-0 right-0 z-30 p-6"> 
            <div class="container mx-auto flex justify-between items-center">
                <a href="/">
                    <img src="/images/logo.png" alt="GoJogja Logo" class="h-12 md:h-16"> 
                </a>
                <nav class="hidden md:flex items-center space-x-8 text-white header-text-shadow">
                    <a href="/" class="font-medium hover:text-gray-200">Home</a>
                    <a href="{{ route('paket-wisata.index') }}" class="font-medium hover:text-gray-200">Wisata Jogja</a>
                    <a href="{{ route('rental.index') }}" class="font-medium hover:text-gray-200">Rental Kendaraan</a>
                    <a href="{{ route('blogs.index') }}" class="font-medium hover:text-gray-200">Blog Wisata</a>
                </nav>
                <div class="flex items-center gap-4 text-white header-text-shadow">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 font-semibold focus:outline-none hover:text-gray-200">
                                <span>Halo, {{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 text-gray-800" style="display: none;">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profil Saya</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-custom-blue font-semibold px-4 py-2 rounded-md hover:bg-gray-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-grow">
            @yield('content')
        </main>

<<<<<<< HEAD
        <footer class="relative text-white pt-20 pb-8 overflow-hidden"> 
=======
        <footer class="relative text-white pt-20 pb-8 overflow-hidden mt-12">
>>>>>>> 8b7375c37325a93ba10144007695c429b7d2fd19
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/footer-background.webp');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-80 z-1"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div><h3 class="text-2xl font-bold mb-4">Kantor Kami</h3><p class="text-gray-200 leading-relaxed">PT GoJogja International<br>Caturtunggal - Kec. Depok,<br>Kabupaten Sleman, Yogyakarta, Indonesia</p></div>
<<<<<<< HEAD
                    <div><h3 class="text-2xl font-bold mb-4">Hubungi Kami</h3><div class="space-y-4"><a href="tel:+6281344081486" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg><span>+62 813-4408-1486</span></a><a href="#" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5.657" ry="5.657"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg><span>@gojogja_id</span></a><a href="mailto:gojogja@gmail.com" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg><span>gojogja@gmail.com</span></a></div></div>
=======
                    
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Hubungi Kami</h3>
                        <div class="space-y-4">
                            <a href="https://wa.me/6281344081486" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                <span>+62 813-4408-1486</span>
                            </a>
                            <a href="https://www.instagram.com/gojogja_id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                <span>@gojogja_id</span>
                            </a>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=gojogja@gmail.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <span>gojogja@gmail.com</span>
                            </a>
                        </div>
                    </div>

>>>>>>> 8b7375c37325a93ba10144007695c429b7d2fd19
                </div>
                <div class="text-center text-gray-200 mt-20"><p class="font-bold">gojogja.com</p><p class="text-sm text-gray-300">Copyright © 2025 gojogja.com</p></div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>