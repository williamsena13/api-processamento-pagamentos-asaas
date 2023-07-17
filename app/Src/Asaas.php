<?php

namespace App\Src;

use App\Http\Resources\ErrorResource;

use Illuminate\Support\Facades\Http;

class Asaas
{
    protected $url;
    protected $header;
    protected $response;
    protected $error;
    public $statusCode;

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

    public function validaRetorno(String $origin = null)
    {
        if ($this->response->failed()) {
            $json = $this->response->body(); // Obtém o JSON
            $array = json_decode($json, true);

            $erro = $array['errors'][0];

            return [
                'status' => 'error',
                'errorCode' => $this->response->status(),
                'errorStatus' =>$erro['code'],
                'msg' =>  $erro['description'],
                'origin' => $origin,
            ];            
        }    
        
        if ($this->response->successful()) {
            return $this->response->json();
        } else {            
            return [
                'status' => 'error',
                'errorCode' => $this->response->status(),
                'errorMessage' => $this->response->body(),
                'origin' => $origin,
            ];
        }
    }

    public function getCustomers()
    {            
        $this->response = Http::withHeaders($this->header)->get($this->url . '/customers');
        
        return $this->validaRetorno('getCustomers');
        //return $this->response;        
    }

    public function getCustomerById($customerId)
    {
        $this->response = Http::withHeaders($this->header)->get($this->url . '/customers/' . $customerId);

        return $this->validaRetorno('getCustomerById');
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
        $this->response = Http::withHeaders($this->header)->post($this->url . '/customers', $param);
        
        return $this->validaRetorno('createCustomer');
    }

    public function restoreCustomer($customerId)
    {
        $this->response = Http::withHeaders($this->header)->delete($this->url . '/customers/' . $customerId);

        $this->validaRetorno();
    }

    public function deleteCustomer($customerId)
    {
        $this->response = Http::withHeaders($this->header)->delete($this->url . '/restore/' . $customerId);

        $this->validaRetorno();
    }

    public function updateCustomer(
        $id, $name, $cnpj, $email = null, $mobile = null, $address = null,
    $addressNumber = null,
    $province = null,
    $postalCode = null,
    $city = null,
    $state = null)
    {

        {
           
            
          }
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

        if( $address !== null ){
            $param['address'] = $address;
        }
        if( $addressNumber !== null ){
            $param['addressNumber'] = $addressNumber;
        }
        if( $province !== null ){
            $param['province'] = $province;
        }
        if( $postalCode !== null ){
            $param['postalCode'] = $postalCode;
        }
        if( $city !== null ){
            $param['city'] = $city;
        }
        if( $state !== null ){
            $param['state'] = $state;
        }

        $this->response = Http::withHeaders($this->header)->post($this->url . '/customers/' . $id, $param);

        return $this->validaRetorno();
    }

    /*
    *
    * PAYMENTS
    *
    */
    

    public function getCustomerPayments($customerId)
    {
        
        $url = "$this->url/payments?customer=$customerId";
        $this->response = Http::withHeaders($this->header)->get($url);//         
        return $this->validaRetorno();
        
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

        $this->response = Http::withHeaders($this->header)->post($url, $payload);
        return $this->validaRetorno();
    }

    public function getQrCodePayment($paymentId)
    {
        $url = $this->url . '/payments/' . $paymentId . '/pixQrCode';

        $this->response = Http::withHeaders($this->header)->get($url);

        return $this->validaRetorno();
    }

    public function payCredit($paymentId, $cardHolder, $cardNumber, $expiryMonth, $expiryYear, $cvc)
    {
        $url = "{$this->url}/payments/{$paymentId}/payWithCreditCard";
    
        $creditCard = [
            'holderName' => $cardHolder,
            'number' => $cardNumber,
            'expiryMonth' => $expiryMonth,
            'expiryYear' => $expiryYear,
            'ccv' => $cvc
        ];
    
        $payload = [
            'creditCard' => $creditCard
        ];
    
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access_token' => env('ASAAS_API_KEY')
        ];
    
        $client = new \GuzzleHttp\Client();
    
        $this->response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $payload
        ]);
    
        return $this->validaRetorno();
    }
    

};