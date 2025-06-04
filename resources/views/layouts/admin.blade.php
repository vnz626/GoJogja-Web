<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categorySelect = document.getElementById("category_id");
            const subcategorySelect = document.getElementById("subcategory_id");

            categorySelect.addEventListener("change", function () {
                const categoryId = this.value;

                // Kosongkan subkategori
                subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

                if (categoryId) {
                    fetch(`/admin/get-subcategories/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(sub => {
                                const opt = document.createElement('option');
                                opt.value = sub.id;
                                opt.textContent = sub.name;
                                subcategorySelect.appendChild(opt);
                            });
                        })
                        .catch(error => {
                            console.error("Gagal mengambil subkategori:", error);
                        });
                }
            });
        });
    </script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="min-h-screen bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">
        <div class="text-2xl font-bold p-6">Admin Panel</div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : '' }}">
                <span></span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.wisata.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.wisata.*') ? 'bg-indigo-800' : '' }}">
                <span></span><span>Kelola Wisata</span>
            </a>
            {{-- <a href="{{ route('admin.rental.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.rental.*') ? 'bg-indigo-800' : '' }}">
                <span></span><span>Kelola Rental</span>
            </a> --}} {{-- eror ketika cba masuk ke menu rental --}}
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-indigo-800 {{ request()->routeIs('admin.blogs.*') ? 'bg-indigo-800' : '' }}">
                <span></span><span>Lihat Blog</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar / Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold"></h1>

            <!-- Profile di pojok kanan -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4f46e5&color=fff' }}"
                        alt="profile" class="rounded-full w-9 h-9 object-cover border-2 border-white shadow">
                    <span class="font-medium text-gray-800 hidden md:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                    <a href="{{ route('profile.show') }}"
                    class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-indigo-100">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 bg-gray-50 flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
