<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'balance', 'pending_amount'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function buyTransactions()
    {
        return $this->hasMany(BuyTransaction::class);
    }

    public function sellTransactions()
    {
        return $this->hasMany(SellTransaction::class);
    }
}
