@extends('layouts.app')

@section('title', ($vehicle['name'] ?? 'Detail Kendaraan') . ' - Rental GoJogja')

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/rental-hero-bg.jpeg');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20 text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold header-text-shadow">{{ $vehicle['name'] ?? 'Nama Kendaraan' }}</h1>
            <p class="text-xl md:text-2xl text-gray-200 header-text-shadow mt-2">{{ $vehicle['type'] ?? 'Tipe Kendaraan' }}</p>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl flex flex-col lg:flex-row gap-8 mt-[-4rem] relative z-20">

            {{-- Konten Kiri --}}
            <div class="lg:w-2/3">
                <div class="mb-6 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $vehicle['image_url'] ?? '/images/rental/default-car.png' }}" alt="{{ $vehicle['name'] ?? 'Gambar Kendaraan' }}" id="mainVehicleImage" class="w-full h-auto max-h-[450px] object-contain">
                </div>

                {{-- Galeri Foto --}}
                @if(isset($vehicle['images']) && count($vehicle['images']) > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Galeri Foto</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        @foreach($vehicle['images'] as $imagePath)
                        <a href="{{ $imagePath }}" data-fancybox="gallery-{{ $vehicle['id'] ?? 'vehicle' }}" class="block rounded-md overflow-hidden border hover:border-custom-blue transition-all duration-200 ease-in-out cursor-pointer"
                           onclick="event.preventDefault(); document.getElementById('mainVehicleImage').src='{{ $imagePath }}'; Fancybox.show([{ src: '{{ $imagePath }}', type: 'image' }], { groupAttr: 'gallery-{{ $vehicle['id'] ?? 'vehicle' }}' });">
                             <img src="{{ $imagePath }}" alt="Foto {{ $vehicle['name'] ?? '' }}" class="w-full h-20 sm:h-24 object-cover">
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <h2 class="text-2xl font-bold text-gray-800 mb-3 mt-8">Deskripsi Kendaraan</h2>
                <article class="prose max-w-none text-gray-600 leading-relaxed mb-6">
                    {!! nl2br(e($vehicle['deskripsi_panjang'] ?? 'Deskripsi lengkap belum tersedia.')) !!}
                </article>

                <h2 class="text-2xl font-bold text-gray-800 mb-3">Fitur Utama</h2>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-gray-600 mb-6">
                    @if(isset($vehicle['fitur_utama']) && count($vehicle['fitur_utama']) > 0)
                        @foreach($vehicle['fitur_utama'] as $fitur)
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-custom-blue mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                {{ $fitur }}
                            </li>
                        @endforeach
                    @else
                        <li>Informasi fitur belum tersedia.</li>
                    @endif
                </ul>
            </div>

            <div class="lg:w-1/3">
                <div class="sticky top-28">
                    <div
                        class="bg-gray-50 p-6 rounded-lg shadow-lg"
                        x-data="{
                            basePrice: {{ $vehicle['price_per_day'] ?? 0 }},
                            optionsCost: {{ json_encode($vehicle['options_cost'] ?? ['lepas_kunci' => 0, 'dengan_sopir' => 150000, 'sopir_bbm' => 250000]) }},
                            selectedDurationValue: '1_hari',
                            customDuration: 1,
                            selectedOption: 'lepas_kunci',
                            get durationDays() {
                                if (this.selectedDurationValue === 'custom') {
                                    const days = parseInt(this.customDuration);
                                    return days > 0 ? days : 1;
                                }
                                const parts = this.selectedDurationValue.split('_');
                                return parseInt(parts[0]) || 1;
                            },
                            get totalCost() {
                                const optionAdditionalCost = this.optionsCost[this.selectedOption] || 0;
                                return (this.basePrice + optionAdditionalCost) * this.durationDays;
                            }
                        }"
                    >
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Pesan Kendaraan Ini</h2>
                        <div class="space-y-3 text-gray-700 mb-6">
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">Jenis:</span><span>{{ $vehicle['type'] ?? 'N/A' }}</span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">Kapasitas:</span><span>{{ $vehicle['kapasitas_penumpang'] ?? 'N/A' }} Penumpang</span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">Transmisi:</span><span>{{ $vehicle['transmisi'] ?? 'N/A' }}</span></div>
                             <div class="flex justify-between"><span class="font-semibold">Bahan Bakar:</span><span>{{ $vehicle['bahan_bakar'] ?? 'N/A' }}</span></div>
                        </div>

                        <div class="mb-6">
                            <p class="text-3xl font-bold text-custom-blue text-center">
                                Rp <span x-text="totalCost.toLocaleString('id-ID')"></span>
                            </p>
                             <p class="text-center text-sm text-gray-500" x-show="durationDays > 0">
                                (<span x-text="durationDays">1</span> hari <span x-text="selectedOption.replace('_', ' ')"></span>)
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="durasi" class="block text-sm font-medium text-gray-700 mb-1">Durasi Sewa</label>
                            <select id="durasi" name="durasi" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" x-model="selectedDurationValue">
                                <option value="1_hari">1 Hari</option>
                                <option value="2_hari">2 Hari</option>
                                <option value="3_hari">3 Hari</option>
                                <option value="7_hari">7 Hari (Mingguan)</option>
                                <option value="custom">Custom (Jumlah Hari)</option>
                            </select>
                        </div>

                        <div x-show="selectedDurationValue === 'custom'" class="mb-4" x-transition.opacity>
                            <label for="custom_duration_days" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Hari</label>
                            <input type="number" id="custom_duration_days" name="custom_duration_days" x-model.number="customDuration" min="1" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" placeholder="Contoh: 5">
                        </div>

                        <div class="mb-6">
                            <label for="opsi_rental" class="block text-sm font-medium text-gray-700 mb-1">Opsi Rental</label>
                            <select id="opsi_rental" name="opsi_rental" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue" x-model="selectedOption">
                                <option value="lepas_kunci">Lepas Kunci</option>
                                <option value="dengan_sopir">Dengan Sopir (+Rp {{ number_format($vehicle['options_cost']['dengan_sopir'] ?? 0, 0, ',', '.') }})</option>
                                <option value="sopir_bbm">Paket Sopir + BBM (+Rp {{ number_format($vehicle['options_cost']['sopir_bbm'] ?? 0, 0, ',', '.') }})</option>
                            </select>
                        </div>


                        <button type="button" class="w-full bg-custom-blue text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors text-lg shadow-md">
                            Pesan Sekarang
                        </button>

                        <div class="mb-6 flex justify-end">
                            <a href="{{ route('rental.index') }}" class="mt-6 w-full text-center bg-custom-blue text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                Kembali ke Rental
                            </a>
                        </div>
                        
                        <p class="text-xs text-gray-500 text-center mt-3">Atau hubungi kami via WhatsApp!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @pushOnce('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    @endPushOnce
    @pushOnce('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            Fancybox.bind("[data-fancybox^='gallery']", {
              Thumbs: false, // Menonaktifkan thumbnail di dalam lightbox jika tidak mau
              Toolbar: {
                display: [
                  "zoom",
                  "slideshow",
                  "fullscreen",
                  "download",
                  "close",
                ],
              },
            });
          });
        </script>
    @endPushOnce
@endsection
