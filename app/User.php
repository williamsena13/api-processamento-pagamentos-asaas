<?php

namespace App;

use App\Models\Payment;
use App\Src\Asaas;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cnpj','name', 'email', 'password','customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateApiKey()
    {
        $this->api_token = Str::random(80);
        $this->save();
    }

    public function setCustomerId($id)
    {
        $this->customer_id = $id;
        $this->save();
    }

    public static function getTokenFromRequest($request)
    {
        if (!$request->header('Authorization')) {
            return response()->json(['error' => 'Usuário não identificado'], 401);
        }
        
        // Extrair o token de API do cabeçalho de autorização
        $apiToken = str_replace('Bearer ', '', $request->header('Authorization'));
        
        return $apiToken;
    }

    public static function authUser($request)
    { 
        return User::where('api_token', User::getTokenFromRequest( $request ))->first();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getAsaasPayments()
    {
        $asaas = new Asaas;
        return $asaas->getCustomerPayments($this->customer_id );        
    }

    public function updateUser($request)
    {
        if (isset($request->cnpj)){
            $this->cnpj = $request->cnpj;
        }
        if (isset($request->name)){
            $this->name = $request->name;
        }
        if (isset($request->mobilePhone)){
            $this->mobile_phone = $request->mobilePhone;
        }

        if (isset($request->customer_id)){
            $this->customer_id = $request->customer_id;
            $this->updateClientAsaas();
        }
        
        $this->save();
        
    }

    public function updateClientAsaas()
    {
        $asaas = new Asaas;
        $asaas->updateCustomer($this->customer_id, $this->name, $this->cnpj, $this->email, $this->mobilePhone ?? null);
    }
}