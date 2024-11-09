<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artisan extends Model
{
    protected $fillable = [
        'name', 'biography', 'municipality_id', 'phone',
        'email', 'address', 'featured', 'status'
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
