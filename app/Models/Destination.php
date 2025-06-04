<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    protected $fillable = [
        'title','description','price','open_time','close_time','subcategory_id','category_id', 'is_popular'
    ];

    // Banyak DestinationImages terkait ke satu Destination
    public function images(): HasMany
    {
        return $this->hasMany(DestinationImage::class);
    }

    // Setiap Destination milik satu Subcategory
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

