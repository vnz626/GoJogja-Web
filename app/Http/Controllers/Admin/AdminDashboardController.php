<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data dashboard
    }

    public function edit($id)
    {
        // Tampilkan form edit data dashboard
        return view('admin.dashboard');
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update data dashboard
    }

    public function destroy($id)
    {
        // Hapus data dashboard
    }
}
