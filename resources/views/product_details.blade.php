@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
        <div class="card-header">
            <div class="float-start">
                Product Information
            </div>
            <div class="float-end">
                <a href="/" class="btn btn-primary btn-sm">&larr; Back</a>
            </div>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6 m-auto" style="height:200px;">
                         <img src="{{ asset("storage/images/".$product->image )}}" alt="" height="150px" width="100%">
                    </div>
                </div>
                <div class="row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $product->name }}
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $product->description }}
                    </div>
                </div>
                <div class="row">
                    <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $product->price }}
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="quantity in stock" class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity In Stock:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $product->qty_in_stock }}
                    </div>
                </div>
               
                
                
        </div>
        <div class="card-footer">
            <h6 class="text-center card-title mb-3" style="font-weight:bold;">Make Order</h6>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ route("cart-store",$product->id)}}" method="POST">
                     @csrf   
                     <div class="row mb-3">
                        <label for="qty" class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                        <div class="col-md-6">
                          <input type="number" min="1" max="{{$product->qty_in_stock}}" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty') }}">
                            @if ($errors->has('qty'))
                                <span class="text-danger">{{ $errors->first('qty') }}</span>
                            @endif
                        </div>
                     </div>
                     <div class="row mb-3">
                        <input type="submit" class="col-md-4 offset-md-5 btn btn-primary" value="Order Product">
                     </div>   
                    </form>
                </div>     
            </div>
        </div>
    </div>
</div>  
</div>
@endsection