<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $fillable = ['description', 'status'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}