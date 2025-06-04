<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to GoJogja</title>

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
                    'overlay-blue': '#6DC3F5',
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
</head>
<body class="font-sans antialiased">
    <div class="w-full">

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
                                <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Logout</button></form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-custom-blue font-semibold px-4 py-2 rounded-md hover:bg-gray-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </header>

        <section class="relative h-screen flex items-center justify-center">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/hero-background.jpeg');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-50"></div>
            <div class="relative z-10 text-center text-white">
                <h1 class="text-5xl md:text-7xl font-bold">Welcome to GoJogja</h1>
            </div>
        </section>

        <main class="container mx-auto px-6 py-16">
            <section class="flex flex-col md:flex-row items-center gap-12 my-12">
                <div class="md:w-1/3">
                    <img src="/images/tugu-jogja.jpg" alt="Tugu Jogja" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="md:w-2/3">
                    <h2 class="text-4xl font-bold text-custom-blue mb-4">GoJogja</h2>
                    <p class="text-gray-600 leading-relaxed font-medium">
                        GoJogja adalah teman perjalanan Anda di Yogyakarta. Dapatkan akses mudah ke informasi wisata, rental kendaraan, paket tur, dan blog perjalanan dalam satu platform. Rencanakan petualangan Anda di Jogja sekarang!
                    </p>
                </div>
            </section>

            <section class="my-20">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Rekomendasi Wisata</h2>
                    <a href="{{ route('paket-wisata.index') }}" class="text-custom-blue font-semibold flex items-center gap-2 hover:underline">
                        <span>Lihat Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
                        <a href="{{ route('paket-wisata.index', ['view_mode' => 'destinasi', 'search' => 'Pantai Parangtritis']) }}" class="block w-full h-full">
                            <img src="/images/parangtritis.webp" alt="Pantai Parangtritis" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Pantai Parangtritis</h3>
                        </a>
                    </div>
                    <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
                         <a href="{{ route('paket-wisata.index', ['view_mode' => 'destinasi', 'search' => 'Malioboro']) }}" class="block w-full h-full">
                            <img src="/images/malioboro.webp" alt="Malioboro" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Malioboro</h3>
                        </a>
                    </div>
                    <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
                        <a href="{{ route('paket-wisata.index', ['view_mode' => 'destinasi', 'search' => 'Taman Sari']) }}" class="block w-full h-full">
                            <img src="/images/taman-sari.jpeg" alt="Taman Sari" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Taman Sari</h3>
                        </a>
                    </div>
                </div>
            </section>

             <section class="my-20">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Rental Kendaraan</h2>
                    <a href="{{ route('rental.index') }}" class="text-custom-blue font-semibold flex items-center gap-2 hover:underline">
                        <span>Lihat Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
                    @if(isset($topVehicles) && $topVehicles->count() > 0)
                        @foreach($topVehicles as $vehicle)
                        <div>
                            <a href="{{ route('rental.show', $vehicle['slug'] ?? $vehicle['id']) }}" class="block group">
                                <img src="{{ $vehicle['image_url'] ?? '/images/rental/default-car.png' }}" alt="{{ $vehicle['name'] }}" class="h-40 mx-auto transform group-hover:scale-105 transition-transform duration-300 rounded-md">
                                <h3 class="font-bold text-lg mt-2 text-gray-800 group-hover:text-custom-blue">{{ $vehicle['name'] }}</h3>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <div>
                            <a href="{{ route('rental.index', ['search' => 'Avanza']) }}" class="block group">
                                <img src="/images/avanza.jpeg" alt="Avanza" class="h-40 mx-auto transform group-hover:scale-105 transition-transform duration-300 rounded-md">
                                <h3 class="font-bold text-lg mt-2 text-gray-800 group-hover:text-custom-blue">Avanza</h3>
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('rental.index', ['search' => 'Sigra']) }}" class="block group">
                                <img src="/images/sigra.jpeg" alt="Sigra" class="h-40 mx-auto transform group-hover:scale-105 transition-transform duration-300 rounded-md">
                                <h3 class="font-bold text-lg mt-2 text-gray-800 group-hover:text-custom-blue">Sigra</h3>
                            </a>
                        </div>
                        <div>
                             <a href="{{ route('rental.index', ['search' => 'Scoopy']) }}" class="block group">
                                <img src="/images/scoopy.jpeg" alt="Scoopy" class="h-40 mx-auto transform group-hover:scale-105 transition-transform duration-300 rounded-md">
                                <h3 class="font-bold text-lg mt-2 text-gray-800 group-hover:text-custom-blue">Scoopy</h3>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

           <section class="my-20">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Blog Wisata</h2>
                    <a href="{{ route('blogs.index') }}" class="text-custom-blue font-semibold flex items-center gap-2 hover:underline">
                        <span>Lihat Semua Artikel</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <img src="/images/blog-kuliner.webp" alt="Kuliner Jogja" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
                        <div class="flex-1">
                            <a href="{{ route('blogs.index', ['search' => 'Kuliner Jogja Bagian Utara']) }}" class="text-xl font-bold text-custom-blue hover:underline">Kuliner Jogja Bagian Utara: Surga Rasa dan Petualangan yang Menggoda</a>
                            <div class="flex items-center text-sm text-gray-500 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>28 Mei 2025</span>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                                Overview Wisata Kuliner Jogja Bagian Utara Jogja tidak hanya terkenal dengan warisan budaya dan sejarahnya...
                            </p>
                        </div>
                        <a href="{{ route('blogs.index', ['search' => 'Kuliner Jogja Bagian Utara']) }}" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <img src="/images/blog-pantai.webp" alt="Pantai Gunungkidul" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
                        <div class="flex-1">
                            <a href="{{ route('blogs.index', ['search' => 'Pantai Sepi di Gunungkidul']) }}" class="text-xl font-bold text-custom-blue hover:underline">7 Pantai Sepi di Gunungkidul yang Wajib Dikunjungi...</a>
                             <div class="flex items-center text-sm text-gray-500 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>25 Mei 2025</span>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                                Mengenal Gunungkidul, Surga Tersembunyi di Ujung Selatan Jogja...
                            </p>
                        </div>
                        <a href="{{ route('blogs.index', ['search' => 'Pantai Sepi di Gunungkidul']) }}" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                     <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <img src="/images/taman-sari2.webp" alt="Taman Sari" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
                        <div class="flex-1">
                            <a href="{{ route('blogs.index', ['search' => 'Taman Sari Yogyakarta']) }}" class="text-xl font-bold text-custom-blue hover:underline">Taman Sari Yogyakarta: 5 Fakta Menarik yang Wajib Anda Ketahui</a>
                             <div class="flex items-center text-sm text-gray-500 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>22 Mei 2025</span>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                               Obelix Hill Jogja, Surganya Sunset dan Spot Instagramable di Yogyakarta Jogja dikenal sebagai kota budaya dan pariwisata yang tak pernah kehilangan pesonanya...
                            </p>
                        </div>
                        <a href="{{ route('blogs.index', ['search' => 'Taman Sari Yogyakarta']) }}" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
           </section>
        </main>

        <footer class="relative text-white pt-20 pb-8 overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/footer-background.webp');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-80 z-1"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div><h3 class="text-2xl font-bold mb-4">Kantor Kami</h3><p class="text-gray-200 leading-relaxed">PT GoJogja International<br>Caturtunggal - Kec. Depok,<br>Kabupaten Sleman, Yogyakarta, Indonesia</p></div>
                    <div><h3 class="text-2xl font-bold mb-4">Hubungi Kami</h3><div class="space-y-4"><a href="tel:+6281344081486" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg><span>+62 813-4408-1486</span></a><a href="#" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 21.172a4 4 0 01-5.656 0l-4-4a4 4 0 010-5.656l1.586-1.586a4 4 0 015.656 0l4 4a4 4 0 010 5.656l-1.586 1.586z" /><path stroke-linecap="round" stroke-linejoin="round" d="M18 12h.01" /></svg><span>@gojogja_id</span></a><a href="mailto:gojogja@gmail.com" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg><span>gojogja@gmail.com</span></a></div></div>
                </div>
                <div class="text-center text-gray-200 mt-20"><p class="font-bold">gojogja.com</p><p class="text-sm text-gray-300">Copyright © 2025 gojogja.com</p></div>
            </div>
        </footer>
    </div>
</body>
</html>
