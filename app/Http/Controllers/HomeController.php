<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\RentalController; // Import RentalController

class HomeController extends Controller
{
    public function index(): View
    {
        // Membuat instance dari RentalController untuk mengakses data kendaraan
        // Ini cara sederhana untuk data dummy. Idealnya data dari database.
        $rentalDataInstance = new RentalController(); 
        // Mengambil semua data kendaraan dari properti yang sudah di-collect
        // Ini mungkin tidak ideal jika __construct RentalController punya dependensi lain.
        // Alternatif: duplikasi data atau buat service. Untuk sekarang, kita ambil beberapa.
        
        $allVehiclesFromRental = $rentalDataInstance->allVehiclesData ?? collect([]); // Pastikan $allVehiclesData public atau ada getter
        
        // Jika $allVehiclesData di RentalController adalah protected, kita tidak bisa akses langsung.
        // Maka kita definisikan ulang di sini untuk contoh, pastikan datanya SAMA.
        $topVehicles = collect([
            // Ambil 3 data yang sama persis dengan ID 1, 9, 3 dari RentalController
            [
                'id' => 1, 
                'name' => 'Grand Avanza', 
                'slug' => 'grand-avanza', // Penting untuk link
                'image_url' => '/images/rental/avanza.jpeg',
            ],
            [
                'id' => 9, 
                'name' => 'Daihatsu Xenia', 
                'slug' => 'daihatsu-xenia',
                'image_url' => '/images/rental/xenia.png',
            ],
            [
                'id' => 3, 
                'name' => 'Honda Vario 125', 
                'slug' => 'honda-vario-125',
                'image_url' => '/images/rental/vario.jpg',
            ],
        ]);


        // Anda juga bisa mengambil data blog di sini
        // $latestBlogs = ... ;

        return view('welcome', [
            'topVehicles' => $topVehicles,
            // 'latestBlogs' => $latestBlogs,
        ]);
    }
}