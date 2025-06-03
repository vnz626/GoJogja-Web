<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogImage extends Model
{
    protected $table = 'blog_images';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['blog_id', 'filename'];

    // Relasi: Gambar dimiliki oleh Blog
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
