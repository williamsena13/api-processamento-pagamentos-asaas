<?php

namespace App\Src;

use App\Http\Resources\ErrorResource;

use Illuminate\Support\Facades\Http;

class Asaas
{
    protected $url;
    protected $header;

    public function __construct()
    {
        $this->url = env('ASAAS_URL');
        $this->header = [
            'Accept' => 'application/json',
            'access_token' => env('ASAAS_API_KEY'),
        ];
    }
    /*
    *
    * CUSTOMERS
    *
    */    

    public function getCustomers()
    {            
        $response = Http::withHeaders($this->header)->get($this->url . '/customers');
        if ($response->failed()) {
            throw new \Exception('Failed to retrieve customers from Asaas API');
        }
        if ( $response->successful() ){            
            return $response->json();
        }

        return $response;        
    }

    public function getCustomerById($customerId)
    {
        $response = Http::withHeaders($this->header)->get($this->url . '/customers/' . $customerId);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }
        if ( $response->successful() ){            
            return $response->body();
        }

        return $response;        
    }

    public function createCustomer($name, $cnpj, $email = null, $mobile = null)
    {
        $param = [
            'name' => $name,
            'cpfCnpj' => $cnpj,
            //'groupName' => env('APP_NAME'),
        ];

        if ($email !== null) {
            $param['email'] = $email;
        }

        if ($mobile !== null) {
            $param['mobilePhone'] = $mobile;
        }
        //dd($param,$this->url);
        $response = Http::withHeaders($this->header)->post($this->url . '/customers', $param);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }
        if ( $response->successful() ){            
            return $response->json();
        }

        return $response;
    }

    public function deleteCustomer($customerId)
    {
        $response = Http::withHeaders($this->header)->delete($this->url . '/customers/' . $customerId);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }
        if ( $response->successful() ){            
            return $response->body();
        }

        return $response;        
    }

    public function updateCustomer($id, $name, $cnpj, $email = null, $mobile = null)
    {
        $param = [
            'name' => $name,
            'cpfCnpj' => $cnpj,
            'groupName' => env('APP_NAME'),
        ];

        if ($email !== null) {
            $param['email'] = $email;
        }

        if ($mobile !== null) {
            $param['mobilePhone'] = $mobile;
        }

        $response = Http::withHeaders($this->header)->post($this->url . '/customers/' . $id, $param);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }
  
        if ( $response->successful() ){            
            return $response->body();
        }

        return $response;
    }

    /*
    *
    * PAYMENTS
    *
    */

    public function getCustomerPayments($customerId)
    {
        try {
            $url = "$this->url/payments?customer=$customerId";
            $response = Http::withHeaders($this->header)->get($url);// 
            
            if ($response->failed()) {
                throw new \Exception('Failed to retrieve customers from Asaas API');
            }    
            if ( $response->successful() ){
                return $response->json();
            }

            return $response;
        } catch (\Exception $e) {
            dd( $e, $e);
            return new ErrorResource($e);
        }
    }

    public function createPayment(
        $billingType, 
        $customerId, 
        $value, 
        $dueDate, 
        $description, 
        $nrReference = null, 
        $nrParc = null, 
        $nrValueParcela = null
    )
    {
        $url = $this->url . '/payments';

        $payload = [
            'billingType' => $billingType,
            'customer' => $customerId,
            'value' => $value,
            'dueDate' => $dueDate,
            'description' => $description,
            'externalReference' => $nrReference,
            'installmentCount' => $nrParc,
            'installmentValue' => $nrValueParcela
        ];

        $response = Http::withHeaders($this->header)->post($url, $payload);

        if ($response->successful()) {
            return $response->json();
        } else {            
            return response()->json([
                'errorCode' => $response->status(),
                'errorMessage' => $response->body(),
            ], 500);
        }
    }

    public function getQrCodePayment($paymentId)
    {
        $url = $this->url . '/payments/' . $paymentId . '/pixQrCode';

        $response = Http::withHeaders($this->header)->get($url);

            if ($response->failed()) {
                throw new \Exception('Failed to retrieve QRCode from Asaas API');
            }  

        if ($response->successful()) {
            return $response->json();
        }

        return $response;
    }

}