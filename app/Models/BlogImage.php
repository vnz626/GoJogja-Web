<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    protected $table = 'blog_images';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['blog_id', 'filename'];

    // Relasi: Gambar dimiliki oleh Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
