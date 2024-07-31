@extends('layouts.app')

@section('content')

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Payment Information
                </div>
                <div class="float-end">
                    <a href="{{ route('payments.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="mb-3 row">
                        <label for="payment-id" class="col-md-4 col-form-label text-md-end text-start"><strong>Payment ID:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->payment_id }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="amount" class="col-md-4 col-form-label text-md-end text-start"><strong>Order Number:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->order_num }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="amount" class="col-md-4 col-form-label text-md-end text-start"><strong>Amount:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->amount }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="currency" class="col-md-4 col-form-label text-md-end text-start"><strong>Currency:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->currency }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="payment-status" class="col-md-4 col-form-label text-md-end text-start"><strong>Status:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            <span class="badge bg-primary"> {{ $payment->payment_status }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="payment-method" class="col-md-4 col-form-label text-md-end text-start"><strong>Payment Method:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->payment_method }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="created-at" class="col-md-4 col-form-label text-md-end text-start"><strong>Created At:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $payment->created_at }}
                        </div>
                    </div>

            </div>
        </div>
       
@endsection