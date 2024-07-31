@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Payment successful</h2>
                <a href="{{ route('welcome') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Products</a>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole("Customer") || Auth::user()->hasRole("Super Admin"))
                <a class="btn btn-dark" href="{{ route('welcome') }}">
                    <i class="bi bi-arrow-right-circle"></i> Continue Shopping</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
