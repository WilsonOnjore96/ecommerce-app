@extends('layouts.app')

@section('content')
    <div class="col">
        <div class="row">
            <div class="col-md-3  me-2 mb-5" style="background-color:#ddd;">
                <div class="row p-3">
                    <div class="col-12 mb-5">
                        <form action="{{ route('search')}}" class="p-3"  method="POST" style="background:#fff; border-radius:5px;">
                            @csrf
                            @method('POST')
                             <input type="text" class="form-control mb-3" name="name" id="">
                            <button class="btn btn-primary text-white" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="col-12 mb-5 text-center " style="background:#fff;border-radius:5px;">
                        <div class="categories p-3">
                            <h5 class="p-2">Categories</h5>
                        <ul class="list-group text-center" style="height:250px; overflow-y:auto;">
                            @forelse($categories as $category)
                            <li class="list-group-item"><a href="{{ route('product-category',$category->id)}}">{{$category->name}}</a></li>
                            @empty
                             <li class="list-group-item">No Categories</li>
                            @endforelse
                        </ul>
                        {{$categories->links()}}
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8 p-4 mb-2" style="background-color:#eee;">
                <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}" style="text-decoration:none; color:black;">Home</a></li>
                          <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('store')}}" style="text-decoration:none; color:black;">Store</a></li>
                        </ol>
                      </nav>
                </div>
                <div class="row p-4">
                    @forelse($products as $product)
                    <div class="col-md-5 m-3 text-center" style="background-color:#fff;padding:10px;border-radius:5px;">
                        <img src="{{ asset("storage/images/".$product->image) }}" alt="" height="200"
                            style="width:100%;background-size:cover;">
                        <h5>{{ $product->name}}</h5>
                        <p>KSH {{ $product->price}}</p>
                        <a href="{{ route("product-details",$product->id)}}" class="btn btn-primary float-start"> More Details</a>
                        <a href="{{ route("addtocart",$product->id)}}" class="btn btn-success float-end">Add to cart</a>
                    </div>
                    @empty
                    <div class="col-md-6 m-auto">
                        <div class="bg-white text-danger">
                          <strong>No Product Availlable</strong>
                        </div>
                  </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
