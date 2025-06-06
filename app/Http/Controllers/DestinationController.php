<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\DestinationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DestinationController extends Controller
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
    
    public function publicShow($id)
    {
        // Data Dummy Lengkap
        $allDestinations = collect([
            ['id' => 1, 'slug' => 'gembira-loka-zoo', 'name' => 'Gembira Loka Zoo', 'type' => 'Kebun Binatang', 'open_hours' => '09:00 - 17:00', 'ticket_price' => 75000, 'images' => collect([['image_path' => '/images/destinasi/gembira_loka.jpg']]), 'description' => 'Kebun binatang terlengkap di Yogyakarta dengan berbagai koleksi satwa dari seluruh dunia.'],
            ['id' => 2, 'slug' => 'candi-prambanan', 'name' => 'Candi Prambanan', 'type' => 'Candi', 'open_hours' => '08:00 - 17:00', 'ticket_price' => 350000, 'images' => collect([['image_path' => '/images/destinasi/prambanan.jpg']]), 'description' => 'Kompleks candi Hindu terbesar di Indonesia, mahakarya abad ke-9.'],
            ['id' => 3, 'slug' => 'malioboro-street', 'name' => 'Malioboro Street', 'type' => 'Area Belanja & Kuliner', 'open_hours' => '24 Jam (toko bervariasi)', 'ticket_price' => 0, 'images' => collect([['image_path' => '/images/destinasi/malioboro.jpg']]), 'description' => 'Jantung kota Jogja, pusat perbelanjaan oleh-oleh, kerajinan tangan, dan kuliner lesehan.'],
            ['id' => 4, 'slug' => 'pantai-parangtritis', 'name' => 'Pantai Parangtritis', 'type' => 'Pantai', 'open_hours' => '24 Jam', 'ticket_price' => 10000, 'images' => collect([['image_path' => '/images/destinasi/parangtritis.jpg']]), 'description' => 'Pantai paling terkenal di Yogyakarta dengan legenda Nyi Roro Kidul dan pemandangan sunset yang indah.'],
            ['id' => 5, 'slug' => 'keraton-yogyakarta', 'name' => 'Keraton Yogyakarta', 'type' => 'Istana & Museum', 'open_hours' => '09:00 - 14:00', 'ticket_price' => 15000, 'images' => collect([['image_path' => '/images/destinasi/keraton.webp']]), 'description' => 'Pusat kebudayaan Jawa dan kediaman resmi Sultan Hamengkubuwono.'],
            ['id' => 6, 'slug' => 'tebing-breksi', 'name' => 'Tebing Breksi', 'type' => 'Wisata Alam & Spot Foto', 'open_hours' => '06:00 - 20:00', 'ticket_price' => 10000, 'images' => collect([['image_path' => '/images/destinasi/breksi.jpg']]), 'description' => 'Bekas tambang batu kapur yang diubah menjadi destinasi wisata dengan ukiran artistik dan pemandangan kota.'],
        ]);

        $allPackages = collect([
            ['id' => 101, 'slug' => 'jogja-classic-heritage-1-hari', 'name' => 'Jogja Classic Heritage (1 Hari)', 'duration_text' => '1 Hari', 'type' => 'Budaya & Sejarah', 'price' => 450000, 'images' => collect([['image_path' => '/images/paket-wisata/paket1.png']]), 'description' => 'Kunjungi Candi Borobudur, Candi Prambanan, dan Keraton Yogyakarta.'],
            ['id' => 102, 'slug' => 'eksplorasi-pantai-gunung-kidul-2h1m', 'name' => 'Eksplorasi Pantai Gunung Kidul (2H1M)', 'duration_text' => '2 Hari 1 Malam', 'type' => 'Alam & Pantai', 'price' => 1200000, 'images' => collect([['image_path' => '/images/paket-wisata/pantai-gk.jpg']]), 'description' => 'Nikmati keindahan pantai-pantai eksotis Gunung Kidul, menginap semalam.'],
            ['id' => 103, 'slug' => 'adventure-merapi-lava-tour-setengah-hari', 'name' => 'Adventure Merapi Lava Tour (Setengah Hari)', 'duration_text' => 'Setengah Hari', 'type' => 'Petualangan', 'price' => 350000, 'images' => collect([['image_path' => '/images/paket-wisata/merapi.jpg']]), 'description' => 'Rasakan sensasi berpetualang di lereng Merapi dengan Jeep.'],
        ]);

        $allItems = $allDestinations->merge($allPackages);

        $item = $allItems->firstWhere('id', (int)$id);

        if (!$item) {
            abort(404);
        }
        
        $destination = (object) $item;
        $destination->category = (object) ($item['category'] ?? ['name' => 'Wisata']);
        $destination->subcategory = (object) ($item['subcategory'] ?? ['name' => $item['type'] ?? 'Umum']);
        $destination->images = collect($item['images'] ?? [])->map(fn($img) => (object) $img);
        $destination->open_time = $item['open_hours'] ?? 'N/A';
        $destination->close_time = '';
        $destination->price = $item['ticket_price'] ?? $item['price'] ?? 0;

        return view('wisata.show', compact('destination'));
    }
}