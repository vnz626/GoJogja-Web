<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Tampilkan semua blog milik user terlogin
    public function index(Request $request) {
        $blogs = Blog::where('user_id', Auth::id())->get();

            $query = Blog::query();

        if ($request->has('sort')) {
            if ($request->sort === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort === 'cheapest') {
                $query->orderBy('price', 'asc');
            }
            // Tambahkan lainnya sesuai kebutuhan
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('subcategory')) {
            $query->where('subcategory', $request->subcategory);
        }

        $blogs = $query->get();

        return view('blogs.index', compact('blogs'));
    }

    // Form untuk membuat blog baru
    public function create() {
        return view('blogs.create');
    }

    // Simpan blog baru
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'kategori' => 'required',
            'subkategori' => 'required',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $data['user_id'] = Auth::id();

        // Simpan video jika ada
        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('blog_videos','public');
        }

        // Simpan data blog
        $blog = Blog::create($data);

        // Simpan setiap gambar yang diupload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('blog_images','public');
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'filename' => $path
                ]);
            }
        }

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dibuat.');
    }

    // Tampilkan halaman detail blog
    public function show(Blog $blog) {
        // Pastikan user hanya bisa lihat miliknya sendiri (opsional)
        return view('blogs.show', compact('blog'));
    }

    // Form edit blog
    public function edit(Blog $blog) {
        return view('blogs.edit', compact('blog'));
    }

    // Update data blog
    public function update(Request $request, Blog $blog) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'kategori' => 'required',
            'subkategori' => 'required',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('video')) {
            // Hapus video lama jika perlu
            $data['video_path'] = $request->file('video')->store('blog_videos','public');
        }

        $blog->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('blog_images','public');
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'filename' => $path
                ]);
            }
        }

        return redirect()->route('blogs.show', $blog)->with('success', 'Blog berhasil diperbarui.');
    }

    // Hapus blog (beserta gambar terkait)
    public function destroy(Blog $blog) {
        $blog->images()->delete(); // hapus gambar di DB
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus.');
    }
}

