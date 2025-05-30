<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi & Paket Wisata Jogja - GoJogja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['Poppins', 'sans-serif'] },
            colors: { 'custom-blue': '#518EF8', 'overlay-blue': '#6DC3F5' }
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
                <a href="/"><img src="/images/logo.png" alt="GoJogja Logo" class="h-12 md:h-16"></a>
                <nav class="hidden md:flex items-center space-x-8 text-white">
                    <a href="/" class="font-medium hover:text-gray-200">Home</a>
                    <a href="{{ route('paket-wisata.index') }}" class="font-medium hover:text-gray-200">Wisata Jogja</a>
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
                                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Logout</button></form>
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
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/paket-wisata-hero-bg.jpeg');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-60 z-1"></div>
            <div class="relative z-10 text-center p-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Jelajahi Pesona Jogja</h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto">Temukan destinasi impian dan paket wisata menarik untuk petualangan Anda berikutnya di Yogyakarta!</p>
            </div>
        </section>

        <section class="bg-gray-100 py-8">
            <div class="container mx-auto px-4">
                <div class="flex justify-center items-center space-x-4 mb-8">
                    <a href="{{ route('paket-wisata.index', ['view_mode' => 'destinasi'] + request()->except(['view_mode', 'filter_pkg_duration', 'filter_pkg_type', 'filter_pkg_price'])) }}" 
                       class="px-6 py-3 rounded-lg font-semibold transition-colors
                              {{ $currentFilters['view_mode'] == 'destinasi' ? 'bg-custom-blue text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-200 shadow' }}">
                        Destinasi Populer
                    </a>
                    <a href="{{ route('paket-wisata.index', ['view_mode' => 'paket'] + request()->except(['view_mode', 'filter_dest_type', 'filter_dest_price'])) }}" 
                       class="px-6 py-3 rounded-lg font-semibold transition-colors
                              {{ $currentFilters['view_mode'] == 'paket' ? 'bg-custom-blue text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-200 shadow' }}">
                        Paket Wisata
                    </a>
                </div>

                <form method="GET" action="{{ route('paket-wisata.index') }}" class="bg-white p-6 rounded-lg shadow-md mb-10">
                    <input type="hidden" name="view_mode" value="{{ $currentFilters['view_mode'] }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-4 lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" name="search" id="search" value="{{ $currentFilters['searchTerm'] ?? '' }}" placeholder="Nama destinasi atau paket..." class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                        </div>

                        @if ($currentFilters['view_mode'] == 'destinasi')
                            <div>
                                <label for="filter_dest_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Destinasi</label>
                                <select name="filter_dest_type" id="filter_dest_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua" {{ !($currentFilters['currentDestType'] ?? null) || ($currentFilters['currentDestType'] ?? null) == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                                    @foreach($filterOptions['uniqueDestTypes'] ?? [] as $type)
                                        <option value="{{ $type }}" {{ ($currentFilters['currentDestType'] ?? null) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filter_dest_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket</label>
                                <select name="filter_dest_price" id="filter_dest_price" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua" {{ !($currentFilters['currentDestPrice'] ?? null) || ($currentFilters['currentDestPrice'] ?? null) == 'semua' ? 'selected' : '' }}>Semua Harga</option>
                                    <option value="<50k" {{ ($currentFilters['currentDestPrice'] ?? null) == '<50k' ? 'selected' : '' }}>< Rp 50.000</option>
                                    <option value="50k-100k" {{ ($currentFilters['currentDestPrice'] ?? null) == '50k-100k' ? 'selected' : '' }}>Rp 50rb - 100rb</option>
                                    <option value=">100k" {{ ($currentFilters['currentDestPrice'] ?? null) == '>100k' ? 'selected' : '' }}>> Rp 100.000</option>
                                </select>
                            </div>
                        @else {{-- Mode Paket Wisata --}}
                            <div>
                                <label for="filter_pkg_duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Paket</label>
                                <select name="filter_pkg_duration" id="filter_pkg_duration" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua" {{ !($currentFilters['currentPkgDuration'] ?? null) || ($currentFilters['currentPkgDuration'] ?? null) == 'semua' ? 'selected' : '' }}>Semua Durasi</option>
                                    @foreach($filterOptions['uniquePkgDurations'] ?? [] as $duration)
                                        <option value="{{ $duration }}" {{ ($currentFilters['currentPkgDuration'] ?? null) == $duration ? 'selected' : '' }}>{{ $duration }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filter_pkg_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Paket</label>
                                <select name="filter_pkg_type" id="filter_pkg_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua" {{ !($currentFilters['currentPkgType'] ?? null) || ($currentFilters['currentPkgType'] ?? null) == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                                     @foreach($filterOptions['uniquePkgTypes'] ?? [] as $type)
                                        <option value="{{ $type }}" {{ ($currentFilters['currentPkgType'] ?? null) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="filter_pkg_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Paket</label>
                                <select name="filter_pkg_price" id="filter_pkg_price" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua" {{ !($currentFilters['currentPkgPrice'] ?? null) || ($currentFilters['currentPkgPrice'] ?? null) == 'semua' ? 'selected' : '' }}>Semua Harga</option>
                                    <option value="<500k" {{ ($currentFilters['currentPkgPrice'] ?? null) == '<500k' ? 'selected' : '' }}>< Rp 500.000</option>
                                    <option value="500k-1.5M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '500k-1.5M' ? 'selected' : '' }}>Rp 500rb - 1.5jt</option>
                                    <option value="1.5M-3M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '1.5M-3M' ? 'selected' : '' }}>Rp 1.5jt - 3jt</option>
                                    <option value=">3M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '>3M' ? 'selected' : '' }}>> Rp 3.000.000</option>
                                </select>
                            </div>
                        @endif
                        <div class="lg:col-start-4">
                             <button type="submit" class="w-full bg-custom-blue text-white font-semibold px-6 py-2.5 rounded-md hover:bg-blue-700 transition-colors">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>

                @if($items->isEmpty())
                    <div class="text-center py-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-2xl text-gray-500">Oops! Tidak ada hasil ditemukan.</p>
                        <p class="text-gray-400 mt-2">Silakan coba dengan kata kunci atau filter yang berbeda.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if ($currentFilters['view_mode'] == 'destinasi')
                            @foreach ($items as $item)
                                <div class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col">
                                    <img src="{{ $item['image_url'] ?? '/images/destinasi/default.jpg' }}" alt="{{ $item['name'] }}" class="w-full h-56 object-cover">
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item['name'] }}</h3>
                                        <span class="inline-block bg-custom-blue text-white text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide mb-2 self-start">{{ $item['type'] }}</span>
                                        <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Jam Buka:</span> {{ $item['open_hours'] }}</p>
                                        <p class="text-sm text-gray-600 mb-3"><span class="font-semibold">Tiket Masuk:</span> Rp {{ number_format($item['ticket_price'], 0, ',', '.') }}</p>
                                        <p class="text-gray-700 text-sm mb-4 leading-relaxed flex-grow">{{ \Illuminate\Support\Str::limit($item['description'], 100) }}</p>
                                        <a href="#" class="mt-auto w-full bg-custom-blue text-white text-center font-semibold py-2.5 px-4 rounded-md hover:bg-blue-700 transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else {{-- Mode Paket Wisata --}}
                            @foreach ($items as $item)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col">
                                <img src="{{ $item['image_url'] ?? '/images/paket-wisata/default.jpg' }}" alt="{{ $item['name'] }}" class="w-full h-56 object-cover">
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item['name'] }}</h3>
                                    <div class="flex items-center text-xs text-gray-500 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>{{ $item['duration_text'] }}</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A2 2 0 013 12V7a4 4 0 014-4z" /></svg>
                                        <span>{{ $item['type'] }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mb-4 leading-relaxed flex-grow">{{ \Illuminate\Support\Str::limit($item['description'], 100) }}</p>
                                    <p class="text-2xl font-bold text-custom-blue mb-4">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/ pax</span>
                                    </p>
                                    <a href="#" class="mt-auto w-full bg-custom-blue text-white text-center font-semibold py-2.5 px-4 rounded-md hover:bg-blue-700 transition-colors">
                                        Lihat Detail Paket
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <footer class="relative text-white pt-20 pb-8 overflow-hidden mt-12">
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