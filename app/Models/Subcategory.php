<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $fillable = ['name'];

    // Relasi one-to-many: satu Subcategory punya banyak Destinations
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
