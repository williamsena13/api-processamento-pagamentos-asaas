<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    protected $fillable = ['name', 'description'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}