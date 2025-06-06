<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RentalController extends Controller
{
    public $allVehiclesData;

    public function __construct()
    {
        $this->allVehiclesData = collect([
            [
                'id' => 1, 
                'name' => 'Grand Avanza', 
                'slug' => 'grand-avanza',
                'type' => 'Mobil', 
                'price_per_day' => 350000, 
                'image_url' => '/images/rental/avanza.jpeg',
                'transmisi' => 'Manual',
                'kapasitas_penumpang' => 7,
                'bahan_bakar' => 'Bensin',
                'tahun' => 2019,
                'fitur_utama' => ['AC Double Blower', 'Audio System (USB, AUX)', 'Airbag'],
                'deskripsi_singkat' => 'Mobil keluarga irit dan handal untuk perjalanan di Jogja.',
                'deskripsi_panjang' => 'Toyota Avanza adalah pilihan populer untuk keluarga dan perjalanan grup kecil. Dengan kapasitas hingga 7 penumpang dan konsumsi bahan bakar yang efisien, Avanza siap menemani petualangan Anda di Yogyakarta. Dilengkapi dengan AC double blower untuk kenyamanan maksimal dan sistem audio standar.',
                'options_cost' => [
                    'lepas_kunci' => 0,
                    'dengan_sopir' => 150000,
                    'sopir_bbm' => 250000,
                ],
                'images' => [
                    '/images/rental/avanza.jpeg',
                    '/images/rental/avanza_interior.jpg',
                    '/images/rental/avanza_side.jpg',
                ]
            ],
            [
                'id' => 2, 
                'name' => 'Toyota Innova Reborn', 
                'slug' => 'toyota-innova-reborn',
                'type' => 'Mobil', 
                'price_per_day' => 550000, 
                'image_url' => '/images/rental/innova.jpg',
                'transmisi' => 'Otomatis',
                'kapasitas_penumpang' => 7,
                'bahan_bakar' => 'Diesel',
                'tahun' => 2020,
                'fitur_utama' => ['AC Digital Triple Blower', 'Captain Seat', 'Premium Audio', 'Kamera Mundur'],
                'deskripsi_singkat' => 'Kenyamanan premium untuk perjalanan bisnis atau keluarga.',
                'deskripsi_panjang' => 'Toyota Innova Reborn menawarkan kenyamanan dan kemewahan superior. Dengan interior yang luas, suspensi yang nyaman, dan mesin diesel yang bertenaga namun efisien, sangat cocok untuk perjalanan jauh atau kebutuhan representatif.',
                'options_cost' => [
                    'lepas_kunci' => 0, // Biasanya Innova tidak lepas kunci, ini contoh
                    'dengan_sopir' => 200000,
                    'sopir_bbm' => 350000,
                ],
                'images' => [
                    '/images/rental/innova.jpg',
                    '/images/rental/innova_interior.jpg',
                ]
            ],
            [
                'id' => 3, 
                'name' => 'Honda Vario 125', 
                'slug' => 'honda-vario-125',
                'type' => 'Motor', 
                'price_per_day' => 75000, 
                'image_url' => '/images/rental/vario.jpg',
                'transmisi' => 'Otomatis',
                'kapasitas_penumpang' => 2,
                'bahan_bakar' => 'Bensin',
                'tahun' => 2021,
                'fitur_utama' => ['Idling Stop System (ISS)', 'Combi Brake System (CBS)', 'Bagasi Luas'],
                'deskripsi_singkat' => 'Motor matic lincah dan irit untuk keliling kota.',
                'deskripsi_panjang' => 'Honda Vario 125 adalah pilihan tepat untuk Anda yang membutuhkan kendaraan roda dua yang gesit, irit, dan mudah dikendarai. Sangat mendukung mobilitas Anda menjelajahi setiap sudut Yogyakarta.',
                'options_cost' => [ // Opsi rental motor biasanya hanya lepas kunci
                    'lepas_kunci' => 0,
                ],
                'images' => [
                    '/images/rental/vario.jpg',
                ]
            ],
            [
                'id' => 9, 
                'name' => 'Daihatsu Xenia', 
                'slug' => 'daihatsu-xenia',
                'type' => 'Mobil', 
                'price_per_day' => 300000, 
                'image_url' => '/images/rental/xenia.png',
                'transmisi' => 'Manual',
                'kapasitas_penumpang' => 7,
                'bahan_bakar' => 'Bensin',
                'tahun' => 2018,
                'fitur_utama' => ['AC Double Blower', 'Audio Standard'],
                'deskripsi_singkat' => 'Alternatif mobil keluarga yang ekonomis.',
                'deskripsi_panjang' => 'Daihatsu Xenia, saudara kembar Avanza, menawarkan fungsionalitas serupa dengan harga sewa yang mungkin lebih kompetitif. Pilihan cerdas untuk anggaran terbatas.',
                'options_cost' => [
                    'lepas_kunci' => 0,
                    'dengan_sopir' => 150000,
                    'sopir_bbm' => 250000,
                ],
                'images' => [
                    '/images/rental/xenia.png',
                ]
            ],
            // Anda bisa menambahkan lebih banyak data kendaraan di sini
        ]);
    }

    public function index(Request $request)
    {
        $allVehicles = $this->allVehiclesData;
        $vehicles = $allVehicles;

        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $vehicles = $vehicles->filter(function ($vehicle) use ($searchTerm) {
                return stripos($vehicle['name'], $searchTerm) !== false || 
                       stripos($vehicle['type'], $searchTerm) !== false;
            });
        }

        $filterType = $request->input('filter_type');
        if ($filterType && $filterType !== 'semua') {
            $vehicles = $vehicles->filter(function ($vehicle) use ($filterType) {
                return $vehicle['type'] === $filterType;
            });
        }

        $sortBy = $request->input('sort_by');
        if ($sortBy) {
            if ($sortBy === 'harga_asc') {
                $vehicles = $vehicles->sortBy('price_per_day');
            } elseif ($sortBy === 'harga_desc') {
                $vehicles = $vehicles->sortByDesc('price_per_day');
            }
        } else {
            $vehicles = $vehicles->sortBy('id');
        }

        return view('rental.index', [
            'vehicles' => $vehicles,
            'searchTerm' => $searchTerm,
            'currentFilterType' => $filterType,
            'currentSortBy' => $sortBy,
            'vehicleTypes' => $allVehicles->pluck('type')->unique()->sort()->values()->all(),
        ]);
    }

    public function show($idOrSlug)
    {
        if (is_numeric($idOrSlug)) {
            $vehicle = $this->allVehiclesData->firstWhere('id', (int)$idOrSlug);
        } else {
            $vehicle = $this->allVehiclesData->firstWhere('slug', $idOrSlug);
        }
        
        if (!$vehicle) {
            abort(404, 'Kendaraan tidak ditemukan');
        }

        $otherVehicles = $this->allVehiclesData->where('id', '!=', $vehicle['id'])->shuffle()->take(3);

        return view('rental.show', compact('vehicle', 'otherVehicles'));
    }
}