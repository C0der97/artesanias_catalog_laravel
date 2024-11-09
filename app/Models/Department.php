<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
