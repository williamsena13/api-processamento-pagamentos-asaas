@extends('layouts.app')

@section('content')
{{ Auth::user()}}
<vc-form-checkout :user="{{Auth::user()}}">
</vc-form-checkout>
@endsection
