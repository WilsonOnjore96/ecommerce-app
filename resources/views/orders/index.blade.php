@extends('layouts.app')

@section('content')
           @if(Auth::user()->hasRole('Customer') || Auth::user()->hasRole('Super Admin'))
                @include('layouts.customer_orders')
           @else
                @include('layouts.merchant_orders')     
           @endif
@endsection
