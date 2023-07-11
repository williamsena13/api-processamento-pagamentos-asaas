<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function getFunction()
    {        
        if ( !Auth::user()){
            return redirect()->route('login');
        }

        return view('checkout');
    }
}