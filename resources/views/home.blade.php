@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <p>This is your application dashboard.</p>
                    @canany(['create-role', 'edit-role', 'delete-role'])
                        <a class="btn btn-primary" href="{{ route('roles.index') }}">
                            <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
                    @endcanany
                    @canany(['create-user', 'edit-user', 'delete-user'])
                        <a class="btn btn-success" href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> Manage Users</a>
                    @endcanany
                    @canany(['create-category', 'edit-category', 'delete-category'])
                        <a class="btn btn-warning" href="{{ route('categories.index') }}">
                            <i class="bi bi-bag"></i> Manage Categories</a>
                    @endcanany
                    @canany(['create-product', 'edit-product', 'delete-product'])
                        <a class="btn btn-secondary" href="{{ route('products.index') }}">
                            <i class="bi bi-bag"></i> Manage Products</a>
                    @endcanany
                    @canany(['view-order','edit-order', 'delete-order'])
                        <a class="btn btn-primary" href="{{ route('orders.index') }}">
                            <i class="bi bi-bag"></i> Manage Orders</a>
                    @endcanany
                    @canany(['create-payment','view-payment','edit-payment', 'delete-payment'])
                        <a class="btn btn-success" href="{{ route('payments.index') }}">
                            <i class="bi bi-bag"></i> Manage Payments</a>
                    @endcanany
                    @if(Auth::user()->hasRole("Customer") || Auth::user()->hasRole("Super Admin"))
                    <a class="btn btn-dark" href="{{ route('welcome') }}">
                        <i class="bi bi-arrow-right-circle"></i> Continue Shopping</a>
                    @endif
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

