<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\User; // Tidak perlu di-import jika sudah di-resolve oleh Laravel

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    // PERBARUI BAGIAN INI
    protected $fillable = [
        'user_id',
        'title',
        'slug', // Tambahkan slug
        'content',
        'kategori',
        'sub_kategori', // Tambahkan sub_kategori
        'video_path',   // Ganti 'video' atau 'image' dengan 'video_path' jika itu nama kolomnya
        // 'image', // Hapus atau sesuaikan jika Anda menggunakan BlogImage untuk semua gambar
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }
}