<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query()->with('images');

        if ($request->has('user_articles') && Auth::check() && $request->user_articles == Auth::id()) {
            $query->where('user_id', Auth::id());
        }

        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $filterCategory = $request->input('filter_category');
        if ($filterCategory && $filterCategory !== 'semua') {
            $query->where('kategori', $filterCategory);
        }
        
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
                case 'terbaru':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
             $query->orderBy('created_at', 'desc');
        }

        $blogs = $query->paginate(9);
        $categories = Blog::select('kategori')->whereNotNull('kategori')->where('kategori', '!=', '')->distinct()->orderBy('kategori')->pluck('kategori')->all();

        return view('blogs.index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'currentCategory' => $filterCategory,
            'currentSortBy' => $sortBy,
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'kategori' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'image_utama' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:102400',
        ]);

        $dataToCreate = [
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title'] . '-' . uniqid()),
            'content' => $validatedData['content'],
            'kategori' => $validatedData['kategori'],
            'sub_kategori' => $validatedData['subkategori'] ?? null,
            'image_url' => null,
            'video_path' => null,
        ];

        if ($request->hasFile('image_utama')) {
            $dataToCreate['image_url'] = $request->file('image_utama')->store('blog_thumbnails', 'public');
        }

        if ($request->hasFile('video')) {
            $dataToCreate['video_path'] = $request->file('video')->store('blog_videos', 'public');
        }

        $blog = Blog::create($dataToCreate);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('blog_images', 'public');
                $blog->images()->create(['filename' => $path]);
            }
        }

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dibuat.');
    }

    public function show(Blog $blog)
    {
        $blog->load('images', 'user');
        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        if (Auth::id() !== $blog->user_id && !(Auth::check() && optional(Auth::user())->is_admin)) {
            abort(403);
        }
        $blog->load('images'); // Pastikan memuat relasi images untuk ditampilkan di form edit
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if (Auth::id() !== $blog->user_id && !(Auth::check() && optional(Auth::user())->is_admin)) {
            abort(403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'kategori' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:blog_images,id',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi|max:102400',
            'remove_video' => 'nullable|boolean',
        ]);

        if ($request->has('delete_images')) {
            $imagesToDelete = BlogImage::whereIn('id', $request->input('delete_images'))->where('blog_id', $blog->id)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->filename);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('blog_images', 'public');
                $blog->images()->create(['filename' => $path]);
            }
        }

        $dataToUpdate = [
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'kategori' => $validatedData['kategori'],
            'sub_kategori' => $validatedData['subkategori'] ?? null,
        ];
        
        if ($blog->title !== $dataToUpdate['title']) {
            $dataToUpdate['slug'] = Str::slug($dataToUpdate['title'] . '-' . uniqid());
        }

        if ($request->hasFile('video')) {
            if ($blog->video_path) { Storage::disk('public')->delete($blog->video_path); }
            $dataToUpdate['video_path'] = $request->file('video')->store('blog_videos', 'public');
        } elseif ($request->input('remove_video') == '1') {
            if ($blog->video_path) { Storage::disk('public')->delete($blog->video_path); }
            $dataToUpdate['video_path'] = null;
        }
        
        $blog->update($dataToUpdate);

        $firstRemainingImage = $blog->refresh()->images()->orderBy('id', 'asc')->first();
        if ($firstRemainingImage && is_null($blog->image_url)) {
            $blog->image_url = $firstRemainingImage->filename;
        } elseif (!$firstRemainingImage) {
            $blog->image_url = null;
        }
        $blog->save();

        return redirect()->route('blogs.show', $blog)->with('success', 'Blog berhasil diperbarui.');
    }

    public function destroy(Blog $blog)
    {
        if (Auth::id() !== $blog->user_id && !(Auth::check() && optional(Auth::user())->is_admin)) {
            abort(403);
        }
        
        if ($blog->image_url) { Storage::disk('public')->delete($blog->image_url); }
        if ($blog->video_path) { Storage::disk('public')->delete($blog->video_path); }
        if ($blog->images) {
            foreach ($blog->images as $image) {
                Storage::disk('public')->delete($image->filename);
            }
        }
        
        $blog->delete();
        
        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus.');
    }

} 