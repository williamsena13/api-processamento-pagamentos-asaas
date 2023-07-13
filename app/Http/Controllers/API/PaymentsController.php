<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{

    public function suaFuncao(Request $request)
    {
        // Verificar se o token de API está presente no cabeçalho de autorização
        try {
            //code...
           
    
            // Encontrar o usuário com base no token de API
            $user = User::authUser($request);
            if ( isset($user)){
                $retorno = $user->getAsaasPayments();
                return response()->json($retorno);
            }
            return response()->json($user);
             
        } catch (\Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'err'=> $e,
                'status' => "Error"
            ],500);
        }
        
    }
    
    public function index(Request $request)
    {
        //]
        
        $user = User::authUser($request);
        if ( isset($user)){
            $retorno = $user->getAsaasPayments();
            return response()->json($retorno);
        }
        return response()->json(['status'=>'error', 'msg' => "Usuário não encontrado"], 401);
    }

    
    public function store(Request $request)
    {
        //
        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}