<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
     protected $fillable = [
        'name',
        'image',
    ];

    public $timestamps = false;

    public function productRef(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
