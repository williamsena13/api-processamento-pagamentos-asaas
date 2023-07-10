<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['description', 'status'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}