<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['title','content','kategori','subkategori','video','image','user_id'];

    // Relasi: Blog dimiliki oleh User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Relasi: Blog memiliki banyak Gambar
    public function images(): HasMany
    {
        return $this->hasMany(BlogImage::class);
    }
}
