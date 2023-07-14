<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    protected $fillable = ['name', 'description'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function getPaymentOption($payment)
    {
        $pay = PaymentOption::where('value', $payment['billingType'])->select('description')->first();
        if ( isset( $pay)){
            $payment['formaPagamento'] = $pay->description ;
            
        } else {
            $payment['formaPagamento'] = "Não cadastrada!";
        }

        if ( $payment['billingType'] === 'PIX' ){
            $qrCode = Payment::getQrCodePayment($payment['id']);
            $payment['codigoQR'] = $qrCode;
        }

        return $payment;

        
    }
}