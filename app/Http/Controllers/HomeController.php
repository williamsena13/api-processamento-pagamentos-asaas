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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( empty(Auth::user()->customer_id) ){
            dd("FAZER ALGO");
        }
        Auth::user()->generateApiKey();
        return view('admin.home');
    }
}