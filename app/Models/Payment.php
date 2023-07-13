<?php

namespace App\Models;

use App\Models\Payment as ModelsPayment;
use App\Src\Asaas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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


    public static function findUserPayments(){
    {
        $user = Auth::user();
        try {
            //code...
            
            $retornoAssas = $user->getAsaasPayments();
            $asaasPayments = $retornoAssas["data"];
            
            return $asaasPayments;
        } catch (\Exception $e) {
            dd( "Erro ao carregar", $e);
        }
        
        
        return view('admin.payments.index');
    }

    }
}