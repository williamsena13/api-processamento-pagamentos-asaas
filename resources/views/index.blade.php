@extends('layouts.app')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Finalize sua Compra</h1>
    <p class="lead">O Asaas é uma plataforma de processamento de pagamento que permite que você registre clientes, crie interface de cobranças para clientes, gere novas cobranças e tenha acesso ao centro de ajuda.</p>

</div>
<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card col-4 mx-auto">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Processamento de Pagamento</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">R$ 500,00</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Registre seus clientes</li>
                    <li>Interface de Cobranças para Clientes</li>
                    <li>Gerar novas cobranças</li>
                    <li>Help center access</li>
                </ul>
                <button href="{{route('login')}}" class="btn btn-lg btn-block btn-primary">Finalizar compra</button>
            </div>
        </div>
    </div>
</div>

@endsection
