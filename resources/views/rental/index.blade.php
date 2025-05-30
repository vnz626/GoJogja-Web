<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kendaraan - GoJogja</title>

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
</head>
<body class="font-sans antialiased">
    <div class="w-full">

        <header class="absolute top-0 left-0 right-0 z-20 p-6">
            <div class="container mx-auto flex justify-between items-center">
                <a href="/">
                    <img src="/images/logo.png" alt="GoJogja Logo" class="h-12 md:h-16">
                </a>
                <nav class="hidden md:flex items-center space-x-8 text-white">
                    <a href="/" class="font-medium hover:text-gray-200">Home</a>
                    <a href="#" class="font-medium hover:text-gray-200">Paket Wisata</a>
                    <a href="{{ route('rental.index') }}" class="font-medium hover:text-gray-200">Rental Kendaraan</a>
                    <a href="#" class="font-medium hover:text-gray-200">Blog Wisata</a>
                </nav>
                <div class="flex items-center gap-4 text-white">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 font-semibold focus:outline-none hover:text-gray-200">
                                <span>Halo, {{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-30 text-gray-800" style="display: none;">
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

        <section class="relative h-screen flex items-center justify-center text-white">
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/rental-hero-bg.jpeg');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-60 z-1"></div>
            <div class="relative z-10 text-center p-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Rental Kendaraan</h1>
                <p class="text-lg md:text-xl max-w-2xl mx-auto">
                    Kami menyediakan layanan rental kendaraan di Jogja dengan harga terjangkau. Bisa sewa kendaraan lepas kunci atau sekaligus dengan sopir, sesuai kebutuhan kamu. Cari tempat sewa kendaraan murah dan terpercaya di Jogja? Di sinilah jawabannya!
                </p>
            </div>
        </section>

        <section class="bg-gray-50 py-6 shadow-md">
            <div class="container mx-auto px-4">
                <form method="GET" action="{{ route('rental.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kendaraan</label>
                        <input type="text" name="search" id="search" value="{{ $searchTerm ?? '' }}" placeholder="Contoh: Avanza, Vario..." class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                    </div>
                    
                    <div>
                        <label for="filter_type" class="block text-sm font-medium text-gray-700 mb-1">Filter Jenis</label>
                        <select name="filter_type" id="filter_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                            <option value="semua" {{ (!$currentFilterType || $currentFilterType == 'semua') ? 'selected' : '' }}>Semua Jenis</option>
                            @foreach($vehicleTypes as $type)
                                <option value="{{ $type }}" {{ $currentFilterType == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="sort_by" id="sort_by" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                            <option value="" {{ !$currentSortBy ? 'selected' : '' }}>Default</option>
                            <option value="harga_asc" {{ $currentSortBy == 'harga_asc' ? 'selected' : '' }}>Harga Terendah - Tertinggi</option>
                            <option value="harga_desc" {{ $currentSortBy == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi - Terendah</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-4 mt-4 md:mt-0 text-right">
                         <button type="submit" class="bg-custom-blue text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                @if($vehicles->isEmpty())
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xl text-gray-500">Oops! Kendaraan tidak ditemukan.</p>
                        <p class="text-gray-400 mt-2">Coba ubah kata kunci pencarian atau filter Anda.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($vehicles as $vehicle)
                        <div class="bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                            <img src="{{ $vehicle['image_url'] ?? '/images/rental/default-car.png' }}" alt="{{ $vehicle['name'] }}" class="w-full h-48 object-contain p-2">
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $vehicle['name'] }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $vehicle['type'] }}</p>
                                <p class="text-xl font-bold text-custom-blue mb-4 mt-auto">
                                    Rp {{ number_format($vehicle['price_per_day'], 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ hari</span>
                                </p>
                                <a href="#" class="mt-auto bg-custom-blue text-white text-center font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <footer class="relative text-white pt-20 pb-8 overflow-hidden mt-12">
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/footer-background.webp');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-80 z-1"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Kantor Kami</h3>
                        <p class="text-gray-200 leading-relaxed">
                            PT GoJogja International<br>
                            Caturtunggal - Kec. Depok,<br>
                            Kabupaten Sleman, Yogyakarta, Indonesia
                        </p>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Hubungi Kami</h3>
                        <div class="space-y-4">
                            <a href="tel:+6281344081486" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+62 813-4408-1486</span>
                            </a>
                            <a href="#" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 21.172a4 4 0 01-5.656 0l-4-4a4 4 0 010-5.656l1.586-1.586a4 4 0 015.656 0l4 4a4 4 0 010 5.656l-1.586 1.586z" />
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M18 12h.01" />
                                </svg>
                                <span>@gojogja_id</span>
                            </a>
                            <a href="mailto:gojogja@gmail.com" class="inline-flex items-center gap-4 bg-white text-gray-800 font-medium rounded-full px-6 py-3 shadow-lg hover:bg-gray-100 transition-colors w-full md:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>gojogja@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center text-gray-200 mt-20">
                    <p class="font-bold">gojogja.com</p>
                    <p class="text-sm text-gray-300">Copyright © 2025 gojogja.com</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>