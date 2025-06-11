<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    protected $fillable = [
        'card_id',
        'type',
        'value',
        'debite_type',
        'credit_type',
        'payment_type',
        'payment_reference',
        'order_id',
    ];

    public $timestamps = false;

    public function cardRef():BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }

    // public function orderRef()
    //{
    //    return $this->belongsTo(Order::class, 'order_id', 'id');
    //}
}
