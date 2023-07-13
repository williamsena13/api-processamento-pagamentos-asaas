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
        
        $user = User::authUser($request);
        if ( isset($user)){
            $retorno = $user->getAsaasPayments();
            for ($i=0; $i < count($retorno['data']) ; $i++) { 
                
                $pay = PaymentOption::where('value', $retorno['data'][$i]['billingType'])->select('description')->first();

                $retorno['data'][$i]['formaPagamento']= isset($pay) ? $pay->description : 'ñ';

                if ( $retorno['data'][$i]['billingType'] === 'PIX' ){
                    $qrCode = Payment::getQrCodePayment($retorno['data'][$i]['id']);
                    $retorno['data'][$i]['codigoQR'] = $qrCode;
                }
            }
            return response()->json($retorno);
        }
        return response()->json(['status'=>'error', 'msg' => "Usuário não encontrado"], 401);
    }

    
    public function store(Request $request)
    {
        //
        try {
            $payment = Payment::storePayment($request);
            $pay = PaymentOption::where('value', $payment['billingType'])->select('description')->first();
            $payment['formaPagamento'] = isset($pay) ? $pay->description : "ñ";
            if ( $payment['formaPagamento'] === 'PIX' ){
                $qrCode = Payment::getQrCodePayment($payment['id']);
                $payment['codigoQR'] = $qrCode;
            }
        } catch (\Exception $e) {
            return response()->json(['erro' => $e, 'msg' => $e->getMessage()], 500);
        }

        try {
            $user = Auth::user();

            $user->updateUser( $request );
        } catch (\Exception $e) {
            //throw $th;
            $user = ['erro' => $e, 'msg' => $e->getMessage()];
        }
        $payments = Payment::findUserPayments();
    
        return response()->json([
            'stauts' => 'ok',                    
            'payments' => $payments,
            'payment' => $payment,
            'user'=> $user
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