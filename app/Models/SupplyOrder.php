<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SupplyOrder extends Model
{
    
    protected $fillable = [
        'product_id',
        'registered_by_user_id',
        'status',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();//Mostra produtos que foram apagados com soft delete
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by_user_id');
    }
}
