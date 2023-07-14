<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentOption;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{

    public function index(Request $request)
    {
        //]
        try {
            $user = User::authUser($request);
            if ( isset($user)){
                $retorno = $user->getAsaasPayments();            
                return response()->json($retorno);
            }
            return response()->json(['status'=>'error', 'msg' => "Usuário não encontrado"], 401);
            //code...
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([ 'status' => 'error','erro' => $e, 'msg' => $e->getMessage(), 'origin' => 'Erro ao buscar contas do usuário'], 500);
        }
    }

    
    public function store(Request $request)
    {
        //
        try {
            $payment = Payment::storePayment($request);     
            
            if ( $payment['status'] == 'erro' ) {
                return response()->json($payment, 500);
            } 
            
        } catch (\Exception $e) {
            return response()->json([ 'status' => 'error','erro' => $e, 'msg' => $e->getMessage(), 'origin' => "Erro ao gravar pagamento"], 500);
        }


        try {
            $payment  = PaymentOption::getPaymentOption( $payment );
        } catch (\Exception $e) {
            return response()->json([ 'status' => 'error','erro' => $e, 'msg' => $e->getMessage(), 'origin' => 'Erro ao buscar formas de pagamento', 'pag' => $payment], 500);
        }

        try {
            $user = Auth::user();

            $user->updateUser( $request );
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([ 'status' => 'error','erro' => $e, 'msg' => $e->getMessage(), 'origin' => 'Erro ao atualizar usuário'], 500);
        }
        
    
        return response()->json([
            'stauts' => 'ok',
            'payment' => $payment,
            'user'=> $user,
        ]);
    }// store()

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}