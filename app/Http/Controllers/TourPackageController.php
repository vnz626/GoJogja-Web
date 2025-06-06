<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        // Default view mode
        $viewMode = $request->input('view_mode', 'destinasi'); // 'destinasi' atau 'paket'

        // ===============================================
        // DATA DUMMY (SAMA SEPERTI ASLINYA)
        // ===============================================
        $allDestinations = collect([
            ['id' => 1, 'slug' => 'gembira-loka-zoo', 'name' => 'Gembira Loka Zoo', 'type' => 'Kebun Binatang', 'open_hours' => '09:00 - 17:00', 'ticket_price' => 75000, 'image_url' => '/images/destinasi/gembira_loka.jpg', 'description' => 'Kebun binatang terlengkap di Yogyakarta dengan berbagai koleksi satwa dari seluruh dunia.'],
            ['id' => 2, 'slug' => 'candi-prambanan', 'name' => 'Candi Prambanan', 'type' => 'Candi', 'open_hours' => '08:00 - 17:00', 'ticket_price' => 350000, 'image_url' => '/images/destinasi/prambanan.jpg', 'description' => 'Kompleks candi Hindu terbesar di Indonesia, mahakarya abad ke-9.'],
            ['id' => 3, 'slug' => 'malioboro-street', 'name' => 'Malioboro Street', 'type' => 'Area Belanja & Kuliner', 'open_hours' => '24 Jam (toko bervariasi)', 'ticket_price' => 0, 'image_url' => '/images/destinasi/malioboro.jpg', 'description' => 'Jantung kota Jogja, pusat perbelanjaan oleh-oleh, kerajinan tangan, dan kuliner lesehan.'],
            ['id' => 4, 'slug' => 'pantai-parangtritis', 'name' => 'Pantai Parangtritis', 'type' => 'Pantai', 'open_hours' => '24 Jam', 'ticket_price' => 10000, 'image_url' => '/images/destinasi/parangtritis.jpg', 'description' => 'Pantai paling terkenal di Yogyakarta dengan legenda Nyi Roro Kidul dan pemandangan sunset yang indah.'],
            ['id' => 5, 'slug' => 'keraton-yogyakarta', 'name' => 'Keraton Yogyakarta', 'type' => 'Istana & Museum', 'open_hours' => '09:00 - 14:00', 'ticket_price' => 15000, 'image_url' => '/images/destinasi/keraton.webp', 'description' => 'Pusat kebudayaan Jawa dan kediaman resmi Sultan Hamengkubuwono.'],
            ['id' => 6, 'slug' => 'tebing-breksi', 'name' => 'Tebing Breksi', 'type' => 'Wisata Alam & Spot Foto', 'open_hours' => '06:00 - 20:00', 'ticket_price' => 10000, 'image_url' => '/images/destinasi/breksi.jpg', 'description' => 'Bekas tambang batu kapur yang diubah menjadi destinasi wisata dengan ukiran artistik dan pemandangan kota.'],
        ]);
        
        $allPackages = collect([
            ['id' => 101, 'slug' => 'jogja-classic-heritage-1-hari', 'name' => 'Jogja Classic Heritage (1 Hari)', 'duration_text' => '1 Hari', 'duration_days' => 1, 'type' => 'Budaya & Sejarah', 'price' => 450000, 'description' => 'Kunjungi Candi Borobudur, Candi Prambanan, dan Keraton Yogyakarta.', 'image_url' => '/images/paket-wisata/paket1.png'],
            ['id' => 102, 'slug' => 'eksplorasi-pantai-gunung-kidul-2h1m', 'name' => 'Eksplorasi Pantai Gunung Kidul (2H1M)', 'duration_text' => '2 Hari 1 Malam', 'duration_days' => 2, 'type' => 'Alam & Pantai', 'price' => 1200000, 'description' => 'Nikmati keindahan pantai-pantai eksotis Gunung Kidul, menginap semalam.', 'image_url' => '/images/paket-wisata/pantai-gk.jpg'],
            ['id' => 103, 'slug' => 'adventure-merapi-lava-tour-setengah-hari', 'name' => 'Adventure Merapi Lava Tour (Setengah Hari)', 'duration_text' => 'Setengah Hari', 'duration_days' => 0.5, 'type' => 'Petualangan', 'price' => 350000, 'description' => 'Rasakan sensasi berpetualang di lereng Merapi dengan Jeep.', 'image_url' => '/images/paket-wisata/merapi.jpg'],

        ]);

        $itemsToDisplay = collect([]);
        $filterOptions = [];
        $currentFilters = [
            'searchTerm' => $request->input('search'),
            'view_mode' => $viewMode
        ];

        // LOGIKA FILTER YANG DIKEMBALIKAN
        if ($viewMode === 'destinasi') {
            $itemsToDisplay = $allDestinations;
            $filterType = $request->input('filter_dest_type');
            $filterPrice = $request->input('filter_dest_price');
            $currentFilters['currentDestType'] = $filterType;
            $currentFilters['currentDestPrice'] = $filterPrice;

            if ($filterType && $filterType !== 'semua') {
                $itemsToDisplay = $itemsToDisplay->filter(fn($item) => $item['type'] === $filterType);
            }
            if ($filterPrice && $filterPrice !== 'semua') {
                $itemsToDisplay = $itemsToDisplay->filter(function ($item) use ($filterPrice) {
                    switch ($filterPrice) {
                        case '<50k': return $item['ticket_price'] < 50000;
                        case '50k-100k': return $item['ticket_price'] >= 50000 && $item['ticket_price'] <= 100000;
                        case '>100k': return $item['ticket_price'] > 100000;
                        default: return true;
                    }
                });
            }
            $filterOptions['uniqueDestTypes'] = $allDestinations->pluck('type')->unique()->sort()->values()->all();

        } elseif ($viewMode === 'paket') {
            $itemsToDisplay = $allPackages;
            $filterDuration = $request->input('filter_pkg_duration');
            $filterType = $request->input('filter_pkg_type');
            $filterPrice = $request->input('filter_pkg_price');
            $currentFilters['currentPkgDuration'] = $filterDuration;
            $currentFilters['currentPkgType'] = $filterType;
            $currentFilters['currentPkgPrice'] = $filterPrice;

            if ($filterDuration && $filterDuration !== 'semua') {
                $itemsToDisplay = $itemsToDisplay->filter(fn($item) => $item['duration_text'] === $filterDuration);
            }
            if ($filterType && $filterType !== 'semua') {
                $itemsToDisplay = $itemsToDisplay->filter(fn($item) => $item['type'] === $filterType);
            }
            if ($filterPrice && $filterPrice !== 'semua') {
                 $itemsToDisplay = $itemsToDisplay->filter(function ($item) use ($filterPrice) {
                    switch ($filterPrice) {
                        case '<500k': return $item['price'] < 500000;
                        case '500k-1.5M': return $item['price'] >= 500000 && $item['price'] <= 1500000;
                        case '1.5M-3M': return $item['price'] > 1500000 && $item['price'] <= 3000000;
                        case '>3M': return $item['price'] > 3000000;
                        default: return true;
                    }
                });
            }
            $filterOptions['uniquePkgDurations'] = $allPackages->pluck('duration_text')->unique()->sort()->values()->all();
            $filterOptions['uniquePkgTypes'] = $allPackages->pluck('type')->unique()->sort()->values()->all();
        }
        
        if ($currentFilters['searchTerm']) {
            $searchTerm = $currentFilters['searchTerm'];
            $itemsToDisplay = $itemsToDisplay->filter(function ($item) use ($searchTerm) {
                return stripos($item['name'], $searchTerm) !== false || stripos($item['description'], $searchTerm) !== false;
            });
        }
        
        return view('paket-wisata.index', [
            'items' => $itemsToDisplay,
            'filterOptions' => $filterOptions,
            'currentFilters' => $currentFilters
        ]);
    }
}