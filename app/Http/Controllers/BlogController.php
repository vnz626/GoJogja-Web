<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage; // Pastikan model ini ada jika Anda menggunakannya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Diperlukan untuk menghapus file
use Illuminate\Support\Str; // Jika Anda ingin menggunakan Str helper di controller

class BlogController extends Controller
{
    /**
     * Menampilkan daftar blog dengan filter, pencarian, dan pengurutan.
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Filter untuk menampilkan hanya artikel milik pengguna yang login jika ada parameter user_articles
        if ($request->has('user_articles') && Auth::check() && $request->user_articles == Auth::id()) {
            $query->where('user_id', Auth::id());
        }
        // Jika Anda ingin semua blog tampil secara default (bukan hanya milik user),
        // Anda bisa mengabaikan kondisi di atas atau membuatnya opsional.
        // Untuk halaman blog publik, biasanya menampilkan semua blog.

        // 1. Filter berdasarkan Pencarian (Search)
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Filter berdasarkan Kategori Blog
        $filterCategory = $request->input('filter_category');
        if ($filterCategory && $filterCategory !== 'semua') {
            $query->where('kategori', $filterCategory);
        }

        // 3. Urutkan (Sort)
        $sortBy = $request->input('sort_by');
        if ($sortBy) {
            switch ($sortBy) {
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'judul_az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'judul_za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'terbaru': // Default atau jika 'terbaru' dipilih
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default pengurutan jika tidak ada parameter sort_by
             $query->orderBy('created_at', 'desc');
        }

        // Ambil data dengan pagination
        $blogs = $query->paginate(9); // Ganti 9 dengan jumlah item per halaman yang Anda inginkan

        // Mengambil semua kategori unik dari database untuk dropdown filter
        $categories = Blog::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori')->all();

        return view('blogs.index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'currentCategory' => $filterCategory,
            'currentSortBy' => $sortBy,
        ]);
    }

    /**
     * Menampilkan form untuk membuat blog baru.
     */
    public function create()
    {
        // Pastikan hanya user yang login yang bisa membuat blog
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat artikel.');
        }
        return view('blogs.create');
    }

    /**
     * Menyimpan blog baru ke database.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Anda tidak diizinkan melakukan aksi ini.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'kategori' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255', // Dibuat nullable jika tidak selalu ada
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:102400', // max 100MB
            'images' => 'nullable|array', // Pastikan input name di form adalah images[]
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048' // Setiap file di array images
        ]);

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'] . '-' . uniqid()); // Membuat slug unik

        // Simpan video jika ada
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('blog_videos', 'public');
        }

        // Simpan data blog
        $data['subkategori'] = $request->input('subkategori');
        unset($data['subkategori']);
        $blog = Blog::create($data);

        // Simpan setiap gambar yang diupload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('blog_images', 'public');
                // Pastikan Model BlogImage ada dan kolomnya sesuai
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'filename' => $path // atau 'path' atau nama kolom yang sesuai
                ]);
            }
        }

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dibuat.');
    }

    /**
     * Menampilkan detail satu blog.
     */
    public function show(Blog $blog)
    {
        // Jika Anda ingin relasi 'images' dan 'user' ikut terbawa:
        // $blog->load('images', 'user');
        return view('blogs.show', ['blog' => $blog->load('images')]);
    }

    /**
     * Menampilkan form untuk mengedit blog.
     */
    public function edit(Blog $blog)
    {
        // Pastikan hanya pemilik blog yang bisa mengedit
        if (Auth::id() !== $blog->user_id) {
            abort(403, 'Anda tidak diizinkan mengedit artikel ini.');
        }
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Mengupdate data blog di database.
     */
    public function update(Request $request, Blog $blog)
    {
        if (Auth::id() !== $blog->user_id) {
            abort(403, 'Anda tidak diizinkan mengedit artikel ini.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'kategori' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:102400',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Update slug jika judul berubah
        if ($blog->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title'] . '-' . uniqid());
        }


        // Simpan video baru jika ada
        if ($request->hasFile('video')) {
            // Hapus video lama jika ada
            if ($blog->video) {
                Storage::disk('public')->delete($blog->video);
            }
            $data['video'] = $request->file('video')->store('blog_videos', 'public');
        }

        // Update kategori dan subkategori
        $data['sub_kategori'] = $request->input('subkategori');
        unset($data['subkategori']);

        $blog->update($data);

        // Simpan gambar baru jika ada (mungkin perlu logika untuk menghapus gambar lama tertentu)
        if ($request->hasFile('images')) {
            // Untuk contoh sederhana, kita tambahkan gambar baru.
            // Untuk sistem yang lebih kompleks, Anda mungkin ingin menghapus gambar lama dulu
            // atau memberikan opsi untuk memilih gambar mana yang dihapus.
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('blog_images', 'public');
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'filename' => $path
                ]);
            }
        }

        return redirect()->route('blogs.show', $blog)->with('success', 'Blog berhasil diperbarui.');
    }

    /**
     * Menghapus blog dari database.
     */
    public function destroy(Blog $blog)
    {
        if (Auth::id() !== $blog->user_id) {
            abort(403, 'Anda tidak diizinkan menghapus artikel ini.');
        }

        // Hapus file gambar terkait dari storage
        if ($blog->images) { // Asumsi relasi 'images' ada di model Blog
            foreach ($blog->images as $image) {
                Storage::disk('public')->delete($image->filename); // atau $image->path
            }
        }
        // Hapus file video terkait dari storage
        if ($blog->video) {
            Storage::disk('public')->delete($blog->video);
        }

        // Hapus record gambar dari tabel blog_images (jika relasi di-setup dengan onDelete cascade, ini otomatis)
        // Jika tidak, $blog->images()->delete(); // sebelum $blog->delete()

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus.');
    }
}
