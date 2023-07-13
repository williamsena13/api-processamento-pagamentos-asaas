@extends('layouts.app')

@section('content')
<vc-form-checkout name="{{ Auth::user()->name}}" email="{{ Auth::user()->email}}" cnpj="{{ Auth::user()->cnpj}}" mobilePhone="{{ Auth::user()->mobile_phone }}"> </vc-form-checkout>
@endsection
