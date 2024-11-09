<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importar HasMany correctamente
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'category_id', 'artisan_id',
        'price', 'dimensions', 'weight', 'featured',
        'status', 'slug'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function artisan(): BelongsTo
    {
        return $this->belongsTo(Artisan::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function images() // Ahora HasMany está correctamente tipado
    {
        return $this->hasMany(ProductImage::class);
    }
}
