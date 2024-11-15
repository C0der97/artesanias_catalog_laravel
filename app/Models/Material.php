<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active', 'properties'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'material_product')->withPivot('quantity')->withTimestamps();
    }
}
