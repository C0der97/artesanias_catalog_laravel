<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model
{
    protected $fillable = ['name', 'description', 'department_id'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function artisans(): HasMany
    {
        return $this->hasMany(Artisan::class);
    }
}
