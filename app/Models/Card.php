<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    protected $fillable = [
        'card_number',
        'balance',
    ];

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    public function userRef(): BelongsTo{

        return $this->belongsTo(User::class, 'id', 'id');

    }

     public function operationsRef(): HasMany
    {
        return $this->hasMany(Operation::class, 'card_id', 'id');
    }
}
