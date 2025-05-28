<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAdjustment extends Model
{

    protected $fillable = [
        'product_id',
        'registered_by_user_id',
        'quantity_changed',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function registeredBy()
{
    return $this->belongsTo(User::class, 'registered_by_user_id');
}
}