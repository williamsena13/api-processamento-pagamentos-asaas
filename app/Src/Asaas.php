<?php

namespace App\Src;

use Illuminate\Support\Facades\Http;

class Asaas
{
    protected $accessToken;
    protected $url;
    protected $header;

    public function __construct()
    {
        $this->url = env('ASAAS_URL');
        $this->accessToken = env('ASAAS_API_KEY');
        $this->header = [
            'Accept' => 'application/json',
            'access_token' => $this->accessToken,
        ];
    }
    /*
    *
    * CUSTOMERS
    *
    */
    public function verificaCadastro()
    {

    }

    public function getCustomers()
    {            
        $response = Http::withHeaders($this->header)->get($this->url . '/customers');
        if ($response->failed()) {
            throw new \Exception('Failed to retrieve customers from Asaas API');
        }
        $retorno = $response->json();
        return $retorno;
    }

    public function getCustomerById($customerId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'access_token' => $this->accessToken,
        ])->get($this->url . '/customers/' . $customerId);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }

        return $response->body();
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
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'access_token' => $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post($this->url . '/customers', $param);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }
        $responseData = $response->json();
        return $response->json();
        // Verifica se a resposta contém a chave "id"
        if (isset($responseData['id'])) {
            return $responseData['id'];
        } else {
            return null; // Ou outra ação caso não exista a chave "id" no retorno
        }
    }

    public function deleteCustomer($customerId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'access_token' => $this->accessToken,
        ])->delete($this->url . '/customers/' . $customerId);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }

        return $response->body();
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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'access_token' => $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post($this->url . '/customers/' . $id, $param);

        if ($response->failed()) {
            return 'cURL Error #' . $response->status();
        }

        return $response->body();
    }




}