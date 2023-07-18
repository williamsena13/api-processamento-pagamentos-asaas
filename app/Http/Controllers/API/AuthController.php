<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Src\Asaas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authUser(Request $request)
    {
        try {
            $user =User::authUser($request); 
            if ( isset($user->customer_id)){
                $asaas = new Asaas;
                $asaasUser = $asaas->getCustomerById( $user->customer_id );

                if  ( $asaasUser['deleted'] && $asaasUser['canEdit'] ) {
                    $asaas->restoreCustomer( $user->customer_id );
                    $asaasUser = $asaas->getCustomerById( $user->customer_id );
                }
                $user->assasCustomer = $asaasUser;
                $user->mobile_phone = $asaasUser['mobilePhone'];


                $user->cep = $asaasUser['postalCode'];
                $user->logradouro = $asaasUser['address'];
                $user->numero = $asaasUser['addressNumber'];
                $user->bairro = $asaasUser['province'];
                $user->uf = $asaasUser['state'];
            }
            return $user; 
        } catch (\Exception $e) {
            return response()->json(
                ['erro' => $e->getMessage(), 'code' => $e->getCode(), 'err' => $e, 'line' => $e->getLine()]
            , 500);
        }
    }

    public function updateProfile(Request $request)
    {

        try {
            $user = Auth::user();            
            $user->updateUser( $request );
            $asaas = new Asaas;
            $asaasUser = $asaas->getCustomerById( $user->customer_id );
            return response()->json([$user, $asaasUser]);
        } catch (\Exception $e) {
            return response()->json(
                ['erro' => $e->getMessage(), 'code' => $e->getCode(), 'err' => $e, 'line' => $e->getLine()]
            , 500);
        }
        return response()->json($request->all());
    }
}