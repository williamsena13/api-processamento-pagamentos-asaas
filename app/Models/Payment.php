<?php

namespace App\Models;


use App\Src\Asaas;

use Illuminate\Support\Facades\Auth;

class Payment {    
    public static function findUserPayments(){
    {
        $user = Auth::user();
        try {
            //code...
            
            $retornoAssas = $user->getAsaasPayments();
            if ( $retornoAssas["data"] ){
                return $retornoAssas["data"];                
            }
            return $retornoAssas;
            
        } catch (\Exception $e) {
            dd( "Erro ao carregar", $e);
        }
        

    }

    

    
}