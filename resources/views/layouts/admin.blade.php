<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Sertakan CSS/JS Breeze (Tailwind) -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar Kiri -->
    <aside class="w-64 bg-gray-800 text-white">
        <div class="p-4 text-lg font-semibold">Admin Panel</div>
        <nav class="mt-4">
            <a href="{{ route('admin.wisata.index') }}" class="block py-2 px-4 hover:bg-gray-700">Kelola Wisata</a>
            <a href="{{ route('admin.rental.index') }}" class="block py-2 px-4 hover:bg-gray-700">Kelola Rental</a>
            <a href="{{ url('blog') }}" class="block py-2 px-4 hover:bg-gray-700">Lihat Blog</a>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col">
        <!-- Header Atas -->
        <header class="bg-white shadow p-4">
            <h1 class="text-2xl font-semibold">Dashboard Admin</h1>
        </header>

        <!-- Main Content -->
        <main class="p-6 bg-gray-50 flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
