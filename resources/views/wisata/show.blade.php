@extends('layouts.app')

@section('title', $destination->name . ' - GoJogja')

@section('content')
    <section class="relative text-white">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ $destination->images->first() ? asset($destination->images->first()->image_path) : '/images/destinasi/default.jpg' }}');"></div>
        <div class="absolute inset-0 bg-overlay-blue opacity-70 z-1"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-32 pb-16 md:pt-40 md:pb-20 text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold header-text-shadow">{{ $destination->name }}</h1>
            <p class="text-xl md:text-2xl text-gray-200 header-text-shadow mt-2">{{ $destination->subcategory->name ?? 'Destinasi Wisata' }}</p>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-xl flex flex-col lg:flex-row gap-8 lg:gap-12 mt-[-4rem] relative z-20">

            <div class="lg:w-2/3">
                @if($destination->images->isNotEmpty())
                <div class="mb-8 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $destination->images->first() ? asset($destination->images->first()->image_path) : '/images/destinasi/default.jpg' }}" alt="{{ $destination->name }}" id="main-image" class="w-full h-auto max-h-[450px] object-cover">
                </div>
                @endif
                
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi</h2>
                <article class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($destination->description)) !!}
                </article>

                @if($destination->images->count() > 1)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Galeri Foto</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($destination->images as $image)
                        <a href="{{ asset($image->image_path) }}" data-fancybox="gallery" class="block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                            <img src="{{ asset($image->image_path) }}" alt="Galeri foto untuk {{ $destination->name }}" class="w-full h-32 object-cover cursor-pointer" onclick="event.preventDefault(); document.getElementById('main-image').src='{{ asset($image->image_path) }}'">
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <aside class="lg:w-1/3">
                <div class="sticky top-28">
                    <div
                        class="bg-gray-50 p-6 rounded-lg shadow-lg"
                        x-data="{
                            ticketCount: 1,
                            visitDate: '{{ now()->toDateString() }}',
                            get formattedVisitDate() {
                                if (!this.visitDate) return 'Belum dipilih';
                                const date = new Date(this.visitDate);
                                return date.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                            },
                            get whatsappUrl() {
                                const phone = '6281344081486';
                                const destinationName = '{{ $destination->name }}';

                                const text = `Halo GoJogja,\n\nSaya tertarik untuk memesan tiket wisata:\n- Destinasi: *${destinationName}*\n- Tanggal Kunjungan: *${this.formattedVisitDate}*\n- Jumlah Tiket: *${this.ticketCount} orang*\n\nMohon informasinya untuk ketersediaan dan total biayanya. Terima kasih.`;
                                
                                return `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
                            }
                        }"
                    >
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">
                            @if ($destination->price > 0)
                                Informasi & Pesan
                            @else
                                Informasi
                            @endif
                        </h2>
                        <div class="space-y-3 text-gray-700 mb-6">
                            <div class="flex items-start border-b pb-2"><span class="font-semibold w-28 flex-shrink-0">Kategori</span><span class="flex-1">: {{ $destination->category->name ?? '-' }}</span></div>
                            <div class="flex items-start border-b pb-2"><span class="font-semibold w-28 flex-shrink-0">Tipe</span><span class="flex-1">: {{ $destination->subcategory->name ?? '-' }}</span></div>
                            <div class="flex items-start border-b pb-2"><span class="font-semibold w-28 flex-shrink-0">Jam Buka</span><span class="flex-1">: {{ $destination->open_time }}</span></div>
                            <div class="flex items-start"><span class="font-semibold w-28 flex-shrink-0">Harga Tiket</span><span class="flex-1 font-bold text-custom-blue">: Rp {{ number_format($destination->price, 0, ',', '.') }}</span></div>
                        </div>

                        {{-- Menampilkan form hanya jika harga tiket lebih dari 0 --}}
                        @if ($destination->price > 0)
                            <div class="space-y-4 border-t pt-6">
                                <div>
                                    <label for="ticket_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                                    <input type="number" id="ticket_count" name="ticket_count" x-model.number="ticketCount" min="1" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                </div>
                                <div>
                                    <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                                    <input type="date" id="visit_date" name="visit_date" x-model="visitDate" :min="'{{ now()->toDateString() }}'" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-custom-blue focus:border-custom-blue">
                                </div>
                            </div>

                            <a :href="whatsappUrl" target="_blank" class="mt-6 w-full flex items-center justify-center gap-2 bg-green-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-600 transition-colors text-lg shadow-md">
                                Pesan via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('paket-wisata.index') }}" class="w-full sm:w-auto inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition-colors">
                ← Kembali ke Daftar Wisata
            </a>
        </div>
    </div>
    
    @pushOnce('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    @endPushOnce
    @pushOnce('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            Fancybox.bind("[data-fancybox='gallery']", {});
          });
        </script>
    @endPushOnce
@endsection