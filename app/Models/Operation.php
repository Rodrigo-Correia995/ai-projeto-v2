<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
