<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model

{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'photo',
        'discount_min_qty',
        'discount',
        'stock_lower_limit',
        'stock_upper_limit',
    ];

    public function isBelowMinimumStock(): bool
    {
        return isset($this->stock_lower_limit) && $this->stock < $this->stock_lower_limit;
    }

    public function isAboveMaximumStock(): bool
    {
        return isset($this->stock_upper_limit) && $this->stock > $this->stock_upper_limit;
    }

    public function hasStockAlert(): bool
    {
        return $this->isBelowMinimumStock() || $this->isAboveMaximumStock();
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function supplyOrder()
    {
        return $this->hasMany(SupplyOrder::class);
    }
    public $timestamps = false;
}
