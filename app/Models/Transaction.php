<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['amount', 'description', 'transaction_status_id', 'payment_id'];

    public function status()
    {
        return $this->belongsTo(TransactionStatus::class, 'transaction_status_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}