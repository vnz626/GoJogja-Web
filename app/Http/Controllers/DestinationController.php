<?php

namespace App\Http\Controllers;
use App\Models\Destination;
use App\Models\Subcategory;
use App\Models\Category;
use App\Http\Requests\DestinationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    // Daftar destinasi untuk dashboard admin
    public function index()
    {
        $destinations = Destination::with('subcategory')->get();
        return view('admin.wisata.index', compact('destinations'));
    }

    // Form tambah destinasi baru (admin)
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.wisata.create', compact('subcategories','categories'));
    }

    // Simpan destinasi baru (admin)
    public function store(DestinationRequest $request)
    {
        $data = $request->validated();
        $destination = Destination::create([
            'title'          => $data['title'],
            'description'    => $data['description'],
            'price'          => $data['price'],
            'open'           => $data['open'],
            'close'          => $data['close'],
            'subcategory_id' => $data['subcategory_id'],
            'category'       => $data['category'],
        ]);

        // Simpan file gambar ke storage disk 'public'
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('destinations', 'public');
                $destination->images()->create(['image_url' => $path]);
            }
        }
        return redirect()->route('admin.wisata.index')
                         ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    // Form edit destinasi (admin)
    public function edit(Destination $destination)
    {
        $subcategories = Subcategory::all();
        return view('admin.wisata.edit', compact('destination','subcategories'));
    }

    // Update destinasi (admin)
    public function update(DestinationRequest $request, Destination $destination)
    {
        $data = $request->validated();
        $destination->update([
            'title'          => $data['title'],
            'description'    => $data['description'],
            'price'          => $data['price'],
            'open'           => $data['open'],
            'close'          => $data['close'],
            'subcategory_id' => $data['subcategory_id'],
            'category'       => $data['category'],
        ]);

        // Jika upload gambar baru, simpan dan hubungkan
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('destinations', 'public');
                $destination->images()->create(['image_url' => $path]);
            }
        }
        return redirect()->route('admin.wisata.index')
                         ->with('success', 'Destinasi berhasil diubah.');
    }

    // Hapus destinasi (admin)
    public function destroy(Destination $destination)
    {
        // Hapus file gambar dari storage
        foreach ($destination->images as $img) {
            Storage::disk('public')->delete($img->image_url);
        }
        $destination->delete(); // otomatis menghapus record images karena cascade
        return redirect()->route('admin.wisata.index')
                         ->with('success', 'Destinasi berhasil dihapus.');
    }

    // Daftar destinasi kategori "Destinasi Populer" (frontend user)
    public function publicIndex()
    {
        $destinations = Destination::with('images','subcategory')
                         ->where('category','Destinasi Populer')
                         ->get();
        return view('paket-wisata.index', compact('destinations'));
    }

    // Detail destinasi (frontend user)
    public function publicShow(Destination $destination)
    {
        return view('paket-wisata.show', compact('destination'));
    }
}
