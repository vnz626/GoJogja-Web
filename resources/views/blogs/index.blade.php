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
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { 'custom-blue': '#518EF8', 'overlay-blue': '#6DC3F5' } } } }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .header-text-shadow { text-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="w-full">
        @include('layouts.navigation-standalone') 

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
                    <a href="{{ route('paket-wisata.index', ['view_mode' => 'destinasi'] + request()->except(['view_mode', 'filter_pkg_duration', 'filter_pkg_type', 'filter_pkg_price'])) }}" class="px-6 py-3 rounded-lg font-semibold transition-colors {{ $currentFilters['view_mode'] == 'destinasi' ? 'bg-custom-blue text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-200 shadow' }}">
                        Destinasi Populer
                    </a>
                    <a href="{{ route('paket-wisata.index', ['view_mode' => 'paket'] + request()->except(['view_mode', 'filter_dest_type', 'filter_dest_price'])) }}" class="px-6 py-3 rounded-lg font-semibold transition-colors {{ $currentFilters['view_mode'] == 'paket' ? 'bg-custom-blue text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-200 shadow' }}">
                        Paket Wisata
                    </a>
                </div>

                <form method="GET" action="{{ route('paket-wisata.index') }}" id="filterForm" class="bg-white p-6 rounded-lg shadow-md mb-10">
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
                                    <option value="semua">Semua Jenis</option>
                                    @foreach($filterOptions['uniqueDestTypes'] ?? [] as $type)
                                        <option value="{{ $type }}" {{ ($currentFilters['currentDestType'] ?? null) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filter_dest_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket</label>
                                <select name="filter_dest_price" id="filter_dest_price" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua">Semua Harga</option>
                                    <option value="<50k" {{ ($currentFilters['currentDestPrice'] ?? null) == '<50k' ? 'selected' : '' }}>< Rp 50.000</option>
                                    <option value="50k-100k" {{ ($currentFilters['currentDestPrice'] ?? null) == '50k-100k' ? 'selected' : '' }}>Rp 50rb - 100rb</option>
                                    <option value=">100k" {{ ($currentFilters['currentDestPrice'] ?? null) == '>100k' ? 'selected' : '' }}>> Rp 100.000</option>
                                </select>
                            </div>
                        @else
                            <div>
                                <label for="filter_pkg_duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Paket</label>
                                <select name="filter_pkg_duration" id="filter_pkg_duration" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua">Semua Durasi</option>
                                    @foreach($filterOptions['uniquePkgDurations'] ?? [] as $duration)
                                        <option value="{{ $duration }}" {{ ($currentFilters['currentPkgDuration'] ?? null) == $duration ? 'selected' : '' }}>{{ $duration }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filter_pkg_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Paket</label>
                                <select name="filter_pkg_type" id="filter_pkg_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua">Semua Jenis</option>
                                     @foreach($filterOptions['uniquePkgTypes'] ?? [] as $type)
                                        <option value="{{ $type }}" {{ ($currentFilters['currentPkgType'] ?? null) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="filter_pkg_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Paket</label>
                                <select name="filter_pkg_price" id="filter_pkg_price" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                    <option value="semua">Semua Harga</option>
                                    <option value="<500k" {{ ($currentFilters['currentPkgPrice'] ?? null) == '<500k' ? 'selected' : '' }}>< Rp 500.000</option>
                                    <option value="500k-1.5M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '500k-1.5M' ? 'selected' : '' }}>Rp 500rb - 1.5jt</option>
                                    <option value="1.5M-3M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '1.5M-3M' ? 'selected' : '' }}>Rp 1.5jt - 3jt</option>
                                    <option value=">3M" {{ ($currentFilters['currentPkgPrice'] ?? null) == '>3M' ? 'selected' : '' }}>> Rp 3.000.000</option>
                                </select>
                            </div>
                        @endif
                        <div class="lg:col-start-4">
                             <button type="submit" class="w-full bg-custom-blue text-white font-semibold px-6 py-2.5 rounded-md hover:bg-blue-700 transition-colors">Terapkan</button>
                        </div>
                    </div>
                </form>

                @if($items->isEmpty())
                    <div class="text-center py-20"><p class="text-2xl text-gray-500">Oops! Tidak ada hasil ditemukan.</p></div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if ($currentFilters['view_mode'] == 'destinasi')
                            @foreach ($items as $item)
                                <div class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col">
                                    <a href="{{ route('paket-wisata.show', $item['slug']) }}">
                                        <img src="{{ $item['image_url'] ?? '/images/destinasi/default.jpg' }}" alt="{{ $item['name'] }}" class="w-full h-56 object-cover">
                                    </a>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item['name'] }}</h3>
                                        <span class="inline-block bg-custom-blue text-white text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide mb-2 self-start">{{ $item['type'] }}</span>
                                        <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Jam Buka:</span> {{ $item['open_hours'] }}</p>
                                        <p class="text-sm text-gray-600 mb-3"><span class="font-semibold">Tiket Masuk:</span> Rp {{ number_format($item['ticket_price'], 0, ',', '.') }}</p>
                                        <p class="text-gray-700 text-sm mb-4 leading-relaxed flex-grow">{{ Str::limit($item['description'], 100) }}</p>
                                        <a href="{{ route('paket-wisata.show', $item['slug']) }}" class="mt-auto w-full bg-custom-blue text-white text-center font-semibold py-2.5 px-4 rounded-md hover:bg-blue-700 transition-colors">Lihat Detail</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($items as $item)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col">
                                <a href="{{ route('paket-wisata.show', $item['slug']) }}">
                                    <img src="{{ $item['image_url'] ?? '/images/paket-wisata/default.jpg' }}" alt="{{ $item['name'] }}" class="w-full h-56 object-cover">
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item['name'] }}</h3>
                                    <div class="flex items-center text-xs text-gray-500 mb-1"><svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>{{ $item['duration_text'] }}</span></div>
                                    <div class="flex items-center text-xs text-gray-500 mb-3"><svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A2 2 0 013 12V7a4 4 0 014-4z" /></svg><span>{{ $item['type'] }}</span></div>
                                    <p class="text-gray-700 text-sm mb-4 leading-relaxed flex-grow">{{ Str::limit($item['description'], 100) }}</p>
                                    <p class="text-2xl font-bold text-custom-blue mb-4">Rp {{ number_format($item['price'], 0, ',', '.') }}<span class="text-sm font-normal text-gray-500">/ pax</span></p>
                                    <a href="{{ route('paket-wisata.show', $item['slug']) }}" class="mt-auto w-full bg-custom-blue text-white text-center font-semibold py-2.5 px-4 rounded-md hover:bg-blue-700 transition-colors">Lihat Detail Paket</a>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </div>
</body>
</html>