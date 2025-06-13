<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'name',
        'image',
    ];


    public function productRef(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public $timestamps = true;
}
