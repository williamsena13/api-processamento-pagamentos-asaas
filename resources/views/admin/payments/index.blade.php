@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Payments') }}</div>

                <div class="card-body">
                    <vc-grid-payments></vc-grid-payments>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
