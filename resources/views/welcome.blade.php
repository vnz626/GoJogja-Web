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
</head>
<body class="font-sans antialiased">
    <div class="w-full">
        
        <header class="absolute top-0 left-0 right-0 z-10 p-6">
            <div class="container mx-auto flex justify-between items-center">
                <a href="#">
                <img src="/images/logo.png" alt="GoJogja Logo" class="h-20">
                </a>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-white font-medium">Home</a>
                    <a href="#" class="text-white font-medium">Paket Wisata</a>
                    <a href="#" class="text-white font-medium">Rental Kendaraan</a>
                    <a href="#" class="text-white font-medium">Blog Wisata</a>
                </nav>
                <a href="#">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </a>
            </div>
        </header>

        <section class="relative h-screen flex items-center justify-center">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/hero-background.jpeg');"></div>
            <div class="absolute inset-0 bg-overlay-blue opacity-50"></div>
            <div class="relative z-5 text-center text-white">
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
        <a href="#" class="text-custom-blue font-semibold flex items-center gap-2 hover:underline">
            <span>Lihat Semua</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
            <img src="/images/parangtritis.webp" alt="parangtritis" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Pantai Parangtritis</h3>
        </div>
        <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
            <img src="/images/malioboro.webp" alt="Malioboro" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Malioboro</h3>
        </div>
        <div class="relative rounded-lg overflow-hidden shadow-lg h-60 group">
            <img src="/images/taman-sari.jpeg" alt="Taman Sari" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">Taman Sari</h3>
        </div>
    </div>
</section>

             <section class="my-20">
     <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Rental Kendaraan</h2>
        <a href="#" class="text-custom-blue font-semibold flex items-center gap-2 hover:underline">
            <span>Lihat Semua</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
        <div>
            <img src="/images/avanza.jpeg" alt="Avanza" class="h-40 mx-auto transform hover:scale-105 transition-transform duration-300">
            <h3 class="font-bold text-lg mt-2">Avanza</h3>
        </div>
        <div>
            <img src="/images/sigra.jpeg" alt="Sigra" class="h-40 mx-auto transform hover:scale-105 transition-transform duration-300">
            <h3 class="font-bold text-lg mt-2">Sigra</h3>
        </div>
        <div>
            <img src="/images/scoopy.jpeg" alt="Scoopy" class="h-40 mx-auto transform hover:scale-105 transition-transform duration-300">
            <h3 class="font-bold text-lg mt-2">Scoopy</h3>
        </div>
    </div>
</section>

           <section class="my-20">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Blog Wisata</h2>
    <div class="space-y-8">
        
        <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <img src="/images/blog-kuliner.webp" alt="Kuliner Jogja" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
            <div class="flex-1">
                <a href="#" class="text-xl font-bold text-custom-blue hover:underline">Kuliner Jogja Bagian Utara: Surga Rasa dan Petualangan yang Menggoda</a>
                <div class="flex items-center text-sm text-gray-500 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>28 Mei 2025</span>
                </div>
                <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                    Overview Wisata Kuliner Jogja Bagian Utara Jogja tidak hanya terkenal dengan warisan budaya dan sejarahnya, tetapi juga sebagai destinasi kuliner yang memikat. Khususnya di bagian utara, wisata kuliner Jogja menyajikan berbagai hidangan yang kaya rasa, memadukan tradisi dan inovasi modern,...
                </p>
            </div>
            <a href="#" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <img src="/images/blog-pantai.webp" alt="Pantai Gunungkidul" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
            <div class="flex-1">
                <a href="#" class="text-xl font-bold text-custom-blue hover:underline">7 Pantai Sepi di Gunungkidul yang Wajib Dikunjungi: Surga Tersembunyi di Jogja</a>
                 <div class="flex items-center text-sm text-gray-500 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>25 Mei 2025</span>
                </div>
                <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                    Mengenal Gunungkidul, Surga Tersembunyi di Ujung Selatan Jogja. Dari pegunungan kapur, goa-goa purba, hingga deretan pantai eksotis yang membentang di pesisir selatan. Meskipun beberapa pantai seperti Baron, Indrayanti,...
                </p>
            </div>
            <a href="#" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <img src="/images/taman-sari2.webp" alt="Taman Sari" class="w-full md:w-56 h-48 md:h-full object-cover rounded-lg">
            <div class="flex-1">
                <a href="#" class="text-xl font-bold text-custom-blue hover:underline">Taman Sari Yogyakarta: 5 Fakta Menarik yang Wajib Anda Ketahui</a>
                 <div class="flex items-center text-sm text-gray-500 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>22 Mei 2025</span>
                </div>
                <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                   Obelix Hill Jogja, Surganya Sunset dan Spot Instagramable di Yogyakarta Jogja dikenal sebagai kota budaya dan pariwisata yang tak pernah kehilangan pesonanya. Dari wisata sejarah, kuliner, sampai tempat nongkrong kekinian, semua bisa kamu temukan di sini. Salah satu destinasi baru...
                </p>
            </div>
            <a href="#" class="bg-custom-blue text-white rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0 self-center hover:bg-blue-600 transition-colors">
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