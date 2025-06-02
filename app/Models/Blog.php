<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['title','content','image','user_id'];

    // Relasi: Blog dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relasi: Blog memiliki banyak Gambar
    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }
}
