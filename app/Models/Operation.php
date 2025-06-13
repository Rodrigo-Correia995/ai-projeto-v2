<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Operation extends Model
{
    protected $fillable = [
        'card_id',
        'type',
        'value',
        'date',
        'debit_type',
        'credit_type',
        'payment_type',
        'payment_reference',
        'order_id',
    ];

    public $timestamps = false;

    public function cardRef(): HasOne
    {
        return $this->hasOne(Card::class,'card_id', 'id');
    }

    public function order()
    {   
    return $this->belongsTo(Order::class);
    }

    // public function orderRef()
    //{
    //    return $this->belongsTo(Order::class, 'order_id', 'id');
    //}
}
