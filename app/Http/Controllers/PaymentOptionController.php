<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use Illuminate\Http\Request;

class PaymentOptionController extends Controller
{
    //
    public function getPaymentOptions()
    {
        $paymentOptions = PaymentOption::orderBy('description')->get();
        return response()->json($paymentOptions);
    }    
}