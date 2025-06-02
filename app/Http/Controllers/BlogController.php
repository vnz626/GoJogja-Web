<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Pastikan model Post sudah ada

class BlogController extends Controller
{
    // Method blog() yang diminta route
    public function index()
    {
        // Misalnya tampilkan view bernama 'blog'
        $blogs = Blog::with('user')->latest()->get();
        return view('blog-wisata.index', compact('blogs'));
    }

    // Method untuk menampilkan detail blog
    public function show($id)
    {
        // Misalnya tampilkan view bernama 'blog-detail' dengan data blog tertentu
        $blog = Blog::with('user')->findOrFail($id);
        return view('blog-wisata.detail', compact('blog'));
    }
    // Method untuk menampilkan form tambah blog
    public function create()
    {
        // Misalnya tampilkan view bernama 'blog-create'
        return view('blog-wisata.create');
    }
    // Method untuk menyimpan blog baru
    public function store(Request $request)
    {
        // Validasi dan simpan data blog baru
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Simpan data ke database (logika penyimpanan tergantung pada model yang digunakan)
        // Blog::create($validatedData);

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('blog.index')->with('success', 'Blog created successfully!');
    }
    // Method untuk menampilkan form edit blog
    public function edit($id)
    {
        // Misalnya tampilkan view bernama 'blog-edit' dengan data blog tertentu
        return view('blog-wisata.edit', ['id' => $id]);
    }
    // Method untuk memperbarui blog
    public function update(Request $request, $id)
    {
        // Validasi dan update data blog
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Update data ke database (logika pembaruan tergantung pada model yang digunakan)
        // Blog::findOrFail($id)->update($validatedData);

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('blog.index')->with('success', 'Blog updated successfully!');
    }
    // Method untuk menghapus blog
    public function destroy($id)
    {
        // Hapus data blog dari database (logika penghapusan tergantung pada model yang digunakan)
        // Blog::destroy($id);

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully!');
    }
    // Method untuk menampilkan halaman kategori blog
    public function category($category)
    {
        // Misalnya tampilkan view bernama 'blog-category' dengan data kategori tertentu
        return view('blog-wisata.category', ['category' => $category]);
    }
    // Method untuk menampilkan halaman tag blog
    public function tag($tag)
    {
        // Misalnya tampilkan view bernama 'blog-tag' dengan data tag tertentu
        return view('blog-wisata.tag', ['tag' => $tag]);
    }
    // Method untuk menampilkan halaman pencarian blog
    public function search(Request $request)
    {
        // Ambil query pencarian dari request
        $query = $request->input('query');

        // Misalnya tampilkan view bernama 'blog-search' dengan data pencarian
        return view('blog-wisata.search', ['query' => $query]);
    }
}
