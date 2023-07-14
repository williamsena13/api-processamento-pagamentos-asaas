<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AsaasResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        // Converte o JSON em um array associativo
        if ($this->resource->failed()) {            
            $json = $this->resource->body(); // Obtém o JSON
            $array = json_decode($json, true);

            $erro = $array['errors'][0];

            return [
                'status' => 'erro',
                'errorCode' => $this->resource->status(),
                'errorStatus' =>$erro['code'],
                'msg' =>  $erro['description'],
            ];
        }        
    
        if ($this->resource->successful()) {
            return $this->resource->json();
        }
    
        return [
            'status' => 'timeout',
            'errorCode' => $this->resource->status(),
            'errorMessage' => $this->resource->body(),
            'msg' => 'Erro ao realizar a requisição da API',
        ];
    }
    
}