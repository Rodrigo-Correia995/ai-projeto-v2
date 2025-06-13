<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'member_id',
        'status',
        'date',
        'total_items',
        'shipping_cost',
        'total',
        'nif',
        'delivery_address',
        'pdf_receipt',
        'cancel_reason',
        'custom',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function items()
    {
        return $this->hasMany(ItemOrder::class, 'order_id');
    }

    public function operation()
    {
        return $this->hasOne(Operation::class, 'order_id');
    }
}