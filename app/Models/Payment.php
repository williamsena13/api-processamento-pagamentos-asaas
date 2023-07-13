<?php
namespace App\Models;

use App\Src\Asaas;
use Illuminate\Support\Facades\Auth;

class Payment
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
            // Lança uma exceção personalizada com a mensagem de erro
            throw new \Exception("Erro ao carregar pagamentos: " . $e->getMessage());
        }
    }

    public static function storePayment($request)
    {
        try {
            $asaas = new Asaas;
            $payment = $asaas->createPayment(
                $request->billingType,
                Auth::user()->customer_id,
                $request->value,
                $request->dueDate,
                $request->description
            );
            return $payment;
        } catch (\Exception $e) {
            // Lança uma exceção personalizada com a mensagem de erro
            throw new \Exception("Erro ao criar pagamento: " . $e->getMessage());
        }
    }

    public static function getQrCodePayment($payment_id)
    { 
        $asaas = new Asaas;
        return $asaas->getQrCodePayment($payment_id);
    }
}