<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function index() {
        $blogs = Blog::with('user')->get(); // Memuat relasi user jika perlu
        return view('admin.blogs.index', compact('blogs'));
    }
    public function show(Blog $blog) {
        return view('admin.blogs.show', compact('blog'));
    }
}
