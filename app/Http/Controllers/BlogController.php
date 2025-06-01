<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Method blog() yang diminta route
    public function blog()
    {
        // Misalnya tampilkan view bernama 'blog'
        return view('blog-wisata.index');
    }
}
