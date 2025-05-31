<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    protected $table = 'settings_shipping_costs';

    protected $fillable = [
        'min_value_threshold',
        'max_value_threshold',
        'shipping_cost',
    ];

    public static function getShippingCostForOrderTotal(float $orderTotal): float
    {
        return self::where('min_value_threshold', '<=', $orderTotal)
            ->where(function ($query) use ($orderTotal) {
                $query->where('max_value_threshold', '>', $orderTotal)
                      ->orWhereNull('max_value_threshold');
            })
            ->orderBy('min_value_threshold', 'desc')
            ->value('shipping_cost') ?? 0.0;
    }
}
