<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminWisataController extends Controller
{
    public function index()
    {
        return view('admin.wisata.index');
    }

    public function create()
    {
        return view('admin.wisata.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data wisata
    }

    public function edit($id)
    {
        // Tampilkan form edit data wisata
        return view('admin.wisata.edit');
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update data wisata
    }

    public function destroy($id)
    {
        // Hapus data wisata
    }
}
