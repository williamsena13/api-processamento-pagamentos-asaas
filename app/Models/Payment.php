<?php

namespace App\Models;


use App\Src\Asaas;

use Illuminate\Support\Facades\Auth;

class Payment  {    
    public static function findUserPayments()
    {
        $user = Auth::user();
        try {
            $retornoAssas = $user->getAsaasPayments();
            if ( $retornoAssas["data"] ){
                return $retornoAssas["data"];                
            }
            return $retornoAssas;
            
        } catch (\Exception $e) {
            dd( "Erro ao carregar", $e);
        }
        

    }    
    public static function storePayment($request)
    {
        $asaas = new Asaas;
        $payment = $asaas->createPayment(
            $request->billingType, 
            Auth::user()->customer_id, 
            $request->value, 
            $request->dueDate, 
            $request->description,
            null,
            null,
            null
        );
        return $payment;
    }
}