<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentOption;
use App\Src\Asaas;
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
            return response()->json([ 'status' => 'error', 'erro' => $e, 'msg' => $e->getMessage(), 'origin' => 'Erro ao buscar contas do usuário'], 500);
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

            $retorno = $user->updateUser( $request );
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([ 'status' => 'error','erro' => $e, 'msg' => $e->getMessage(), 'origin' => 'Erro ao atualizar usuário'], 500);
        }
        
    
        return response()->json([
            'stauts' => 'ok',
            'payment' => $payment,
            'user'=> $user,
            'retorno' => $retorno
        ]);
    }// store()

    public function paycharge(Request $request)
    { 
        if ( empty($request->paymentId)){
            return response('Conta não informada!', 400);
        }
        if ( empty($request->cardHolder) ){
            return response('Titular não informado!' , 400);
        }
        if ( empty($request->cardNumber) ){
            return response('Nº do cartão não informado!' , 400);
        }
        if ( empty($request->expiryMonth) ){
            return response('Mês da validade não informado!' , 400);
        }
        if ( empty($request->expiryYear) ){
            return response('Ano da validade não informado!' , 400);
        }
        if( empty($request->cvc)){
            return response('CVC não informado!' , 400);
        }

        try {
            //            
            $asaas = new Asaas;
            $retorno = $asaas->payCredit($request->paymentId, $request->cardHolder, $request->cardNumber, $request->expiryMonth, $request->expiryYear, $request->cvc);
            return response()->json($retorno);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
                'err' => $e, 
                'linha' => $e->getLine(),
            ],500);
        }
        
    }
}