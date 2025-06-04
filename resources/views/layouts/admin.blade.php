<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="min-h-screen bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">
        <div class="text-2xl font-bold p-6">Admin Panel</div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : '' }}">
                <span>🏠</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.wisata.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.wisata.*') ? 'bg-indigo-800' : '' }}">
                <span>🗺️</span><span>Kelola Wisata</span>
            </a>
            <a href="{{ route('admin.rental.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.rental.*') ? 'bg-indigo-800' : '' }}">
                <span>🚗</span><span>Kelola Rental</span>
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.blogs.*') ? 'bg-indigo-800' : '' }}">
                <span>📝</span><span>Lihat Blog</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar / Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="https://i.pravatar.cc/40" alt="profile" class=" absolute right-16 mt-7 rounded-full w-10 h-10">
                <span class="absolute right-3 mt-7 font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 bg-gray-50 flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
