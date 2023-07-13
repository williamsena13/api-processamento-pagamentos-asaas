<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{

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
        try {
            $payment = Payment::storePayment($request);
            
        } catch (\Exception $e) {
            return response()->json(['erro' => $e, 'msg' => $e->getMessage()], 500);
        }
        $payments = Payment::findUserPayments();
        return response()->json([
            'stauts' => 'ok',                    
            'payments' => $payments,
            'payment' => $payment,            
        ]);
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