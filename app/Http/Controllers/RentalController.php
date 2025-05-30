<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection; // Penting untuk manipulasi array

class RentalController extends Controller
{
    public function index(Request $request)
    {
        // Data Kendaraan Dummy (Contoh)
        $allVehicles = collect([
            ['id' => 1, 'name' => 'Grand Avanza', 'type' => 'Mobil', 'price_per_day' => 350000, 'image_url' => '/images/rental/avanza.jpeg'],
            ['id' => 2, 'name' => 'Toyota Innova Reborn', 'type' => 'Mobil', 'price_per_day' => 550000, 'image_url' => '/images/rental/innova.jpg'],
            ['id' => 3, 'name' => 'Honda Vario 125', 'type' => 'Motor', 'price_per_day' => 75000, 'image_url' => '/images/rental/vario.jpg'],
            ['id' => 4, 'name' => 'Yamaha NMAX', 'type' => 'Motor', 'price_per_day' => 120000, 'image_url' => '/images/rental/nmax.avif'],
            ['id' => 5, 'name' => 'Toyota HiAce Commuter', 'type' => 'Minibus', 'price_per_day' => 1200000, 'image_url' => '/images/rental/hiace.jpg'],
            ['id' => 6, 'name' => 'Isuzu Elf Long', 'type' => 'Minibus', 'price_per_day' => 1000000, 'image_url' => '/images/rental/elf.jpg'],
            ['id' => 7, 'name' => 'Bus Pariwisata SHD', 'type' => 'Bus', 'price_per_day' => 3000000, 'image_url' => '/images/rental/bus-shd.jpg'],
            ['id' => 8, 'name' => 'Bajaj Qute Roda 3', 'type' => 'Bajaj', 'price_per_day' => 150000, 'image_url' => '/images/rental/bajaj.avif'],
            ['id' => 9, 'name' => 'Daihatsu Xenia', 'type' => 'Mobil', 'price_per_day' => 300000, 'image_url' => '/images/rental/xenia.png'],
            ['id' => 10, 'name' => 'Honda PCX 160', 'type' => 'Motor', 'price_per_day' => 130000, 'image_url' => '/images/rental/pcx.avif'],
            ['id' => 11, 'name' => 'Medium Bus (35 Seat)', 'type' => 'Bus', 'price_per_day' => 2200000, 'image_url' => '/images/rental/bus-medium.webp'],
            ['id' => 12, 'name' => 'Mitsubishi Pajero Sport', 'type' => 'Mobil', 'price_per_day' => 900000, 'image_url' => '/images/rental/pajero.jpg'],
            ['id' => 12, 'name' => 'Sigra', 'type' => 'Mobil', 'price_per_day' => 250000, 'image_url' => '/images/rental/sigra.jpeg'],
            ['id' => 12, 'name' => 'Honda Scoopy', 'type' => 'Motor', 'price_per_day' => 100000, 'image_url' => '/images/rental/scoopy.jpeg'],
        ]);

        $vehicles = $allVehicles;

        // 1. Filter berdasarkan Pencarian (Search)
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $vehicles = $vehicles->filter(function ($vehicle) use ($searchTerm) {
                return stripos($vehicle['name'], $searchTerm) !== false;
            });
        }

        // 2. Filter berdasarkan Jenis Kendaraan
        $filterType = $request->input('filter_type');
        if ($filterType && $filterType !== 'semua') {
            $vehicles = $vehicles->filter(function ($vehicle) use ($filterType) {
                return $vehicle['type'] === $filterType;
            });
        }

        // 3. Urutkan (Sort)
        $sortBy = $request->input('sort_by');
        if ($sortBy) {
            if ($sortBy === 'harga_asc') {
                $vehicles = $vehicles->sortBy('price_per_day');
            } elseif ($sortBy === 'harga_desc') {
                $vehicles = $vehicles->sortByDesc('price_per_day');
            }
        }

        return view('rental.index', [
            'vehicles' => $vehicles,
            'searchTerm' => $searchTerm,
            'currentFilterType' => $filterType,
            'currentSortBy' => $sortBy,
            'vehicleTypes' => $allVehicles->pluck('type')->unique()->sort()->values()->all(), // Untuk opsi filter
        ]);
    }
}