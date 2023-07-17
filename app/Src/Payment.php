<?php
namespace App\Src;


use Illuminate\Support\Facades\Auth;

class Payment extends Asaas
{
    public static function findUserPayments()
    {
        $user = Auth::user();
        try {
            $retornoAsaas = $user->getAsaasPayments();
            if ($retornoAsaas["data"]) {
                return $retornoAsaas["data"];
            }
            return $retornoAsaas;
        } catch (\Exception $e) {
            throw new \Exception("Erro ao carregar pagamentos: " . $e->getMessage());
        }
    }

    public static function storePayment($request)
    {
        
        $asaas = new Payment;
        $payment = $asaas->createPayment(
            $request->billingType,
            Auth::user()->customer_id,
            $request->value,
            $request->dueDate,
            $request->description
        );

        return $payment;
    }

    public static function getPaymentQrCode($payment_id)
    { 
        $asaas = new Payment;
        return $asaas->getQrCodePayment($payment_id);
    }
}