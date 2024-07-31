@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-12" id="header-img">
         <a href="{{ url('/')}}" class="shop-btn">Shop Now</a>
    </div>
</div>
<div class="row mb-5">
    <div class="col-md-6 text-center mb-5">
        <div class="content p-5 bg-primary text-white">
             <p>A variety of local and global products availlable</p>
        </div>
    </div>
    <div class="col-md-6 text-center mb-5">
        <div class="content p-5 bg-danger text-white">
        <p>Free Delivery available countrywide</p>
        </div>
    </div>
</div>
<div class="row mb-5">    
    <h2 class="text-center text-warning" id="products-header">Our Products</h2>  
    <hr style="border:2px solid black;"> 
    @forelse($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card" id= "product-display-card">
            <img src="{{ asset("storage/images/".$product->image)}}" class="card-img-top" height="200" width="100%">
            <div class="card-body">
               <h5 class="card-title">{{ $product->name}}</h5> 
               <p class="card-text">Price:${{ $product->price}}</p>
               {{-- <p class="card-text">Quantity: {{ $product->qty_in_stock}}</p> --}}
            </div>
            <div class="card-footer bg-white text-center">
                  <a href="{{ route("product-details",$product->id)}}" class="btn btn-primary float-start"> More Details</a>
                  <a href="{{ route("addtocart",$product->id)}}" class="btn btn-success float-end">Add to cart</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-8 mb-4 m-auto">

        <div class="card">
              <div class="card-body">
                <strong>No Product Availlable</strong>
              </div>
        </div>
    </div>

    @endforelse
</div>
{{$products->links()}}
@endsection