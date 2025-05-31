<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipFee extends Model
{

    protected $table = 'settings';

    protected $fillable = [
        'membership_fee',
    ];
    
    public static function getSettings(): self
    {
        return self::first(); 
    }
}
