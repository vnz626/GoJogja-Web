<?php

// app/Http/Controllers/Admin/WisataController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRental;
use Illuminate\Http\Request;

class AdminRentalController extends Controller
{
    public function index()
    {
        $rentals = AdminRental::all();
        return view('admin.rental.index', compact('rentals'));
    }

    public function create()
    {
        return view('admin.rental.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan rental baru
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            // ...
        ]);
        AdminRental::create($data);
        return redirect()->route('rental.index');
    }

    public function edit(AdminRental $rental)
    {
        return view('admin.rental.edit', compact('rental'));
    }

    public function update(Request $request, AdminRental $rental)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            // ...
        ]);
        $rental->update($data);
        return redirect()->route('rental.index');
    }

    public function destroy(AdminRental $rental)
    {
        $rental->delete();
        return redirect()->route('rental.index');
    }
}
