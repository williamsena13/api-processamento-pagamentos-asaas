<?php

namespace App\Http\Controllers;

use App\Src\Asaas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index()
    {
        if ( empty(Auth::user()->customer_id) ){
            
            Auth::user()->createAsaasUser(Auth::user());
        }
        Auth::user()->generateApiKey();
        //return view('admin.home');
        return view('admin.checkout');
    }

    public function profile()
    {
        return view('admin.home');
    }
}