@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-3 text-center">
        <h2>Finalize sua compra</h2>
    </div>

    <div class="row">
        <div class="col-md-8 order-md-1">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <label for="cep">Nome Completo</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="col-12">
                            <label for="cep">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" required>
                            <div class="invalid-feedback">
                                Favor inserir um e-amil válido
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="cep">CPF/CNPJ</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->cnpj }}" required>
                            <div class="invalid-feedback">
                                Favor inserir um CPF/CNPJ válido
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="cep">Celular</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <select class="custom-select">
                                        <option selected>+55</option>

                                    </select>
                                </div>
                                <input type="tel" class="form-control" placeholder="(00) 0000-0000">
                            </div>

                        </div>
                    </div>


                    <h4 class="mb-3" style="padding-top: 20px">Forma de Pagamento</h4>
                    <vc-payment-options></vc-payment-options>
                    <!--
            <form class="needs-validation" novalidate>
                <h4 class="mb-3">Endereço</h4>
                <div class="row">
                    <div class="col-3">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" placeholder="00.000-000" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-7">
                        <label for="address">Endereço</label>
                        <input type="text" class="form-control" id="address" placeholder="Rua Exemplo," required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-2">
                        <label for="address">Nº</label>
                        <input type="text" class="form-control" id="numero" placeholder="123" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="address">Complemento</label>
                        <input type="text" class="form-control" id="numero" placeholder="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-2">
                        <label for="address">UF</label>
                        <select class="custom-select d-block w-100" id="country" required>
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="address">Cidade</label>
                        <select class="custom-select d-block w-100" id="country" required>
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                    </div>

                </div>

                
                

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        -->
                </div>
            </div>
        </div>
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Página de Checkout</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Second product</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$20</strong>
                </li>
            </ul>

            <form class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
