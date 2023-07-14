<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'payment_option_id', 'payment_status_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}