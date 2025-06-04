<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\DestinationImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminWisataController extends Controller
{
    public function index()
    {
        $destinations = Destination::with(['category', 'subcategory'])->latest()->get();
        return view('admin.wisata.index', compact('destinations'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.wisata.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'open_time' => 'required',
            'close_time' => 'required',
            'subcategory_id' => 'required|exists:subcategories,id',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $destination = Destination::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'subcategory_id' => $request->subcategory_id,
                'category_id' => $request->category_id,
                'is_popular' => $request->has('is_popular'),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('destinations', 'public');
                    DestinationImage::create([
                        'destination_id' => $destination->id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.wisata.index')->with('success', 'Destinasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $destination = Destination::with('images')->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.wisata.edit', compact('destination', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'open_time' => 'required',
            'close_time' => 'required',
            'subcategory_id' => 'required|exists:subcategories,id',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $destination->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'subcategory_id' => $request->subcategory_id,
                'category_id' => $request->category_id,
                'is_popular' => $request->has('is_popular'),
            ]);

            if ($request->hasFile('images')) {
                // Optional: hapus gambar lama
                foreach ($destination->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }

                foreach ($request->file('images') as $image) {
                    $path = $image->store('destinations', 'public');
                    DestinationImage::create([
                        'destination_id' => $destination->id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.wisata.index')->with('success', 'Destinasi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        // Hapus gambar terkait
        foreach ($destination->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $destination->delete();
        return redirect()->route('admin.wisata.index')->with('success', 'Destinasi berhasil dihapus.');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }
}
