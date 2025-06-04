<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRentalController extends Controller
{
    public function index()
    {
        return view('admin.rental.index');
    }

    public function create()
    {
        return view('admin.rental.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data rental
    }

    public function edit($id)
    {
        // Tampilkan form edit data rental
        return view('admin.rental.edit');
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update data rental
    }

    public function destroy($id)
    {
        // Hapus data rental
    }
}
