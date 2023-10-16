<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'amount',
        'from',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
