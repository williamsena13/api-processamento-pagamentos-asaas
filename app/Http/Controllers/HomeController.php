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
        //
        try {
            //code...
            $user = Auth::user() ;
            $asas = new Asaas();
            $clientes = $asas->getCustomers();
            /*
            $cadastro = false;
            
            foreach ($clientes as $cliente) {
                # code...
                //Auth
                if (  $cliente['cpfCnpj'] == $user->cnpj ){
                    $cadastro = true;
                }
            }
            if ( !$cadastro ){
                dd($asas, $retorno);
            }
            */


        } catch (\Exception $e) {
            dd("ERRO AO BUSCAR CLIENTES", $e->getMessage(), $e);
        }
        return view('home');
    }
}