
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Product
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 m-auto">
                        <img src="{{ asset("storage/images/".$product->image)}}" class="card-img-top" height="200" width="50%">
                    </div>
                </div>
                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $product->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <!---------price------------>
                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                        <div class="col-md-6">
                          <input type="number" min="1" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price',$product->price) }}">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    <!----------end_price----------------->
                    

                    <!---------qty-in-stock----->
                    <div class="mb-3 row">
                        <label for="qty" class="col-md-4 col-form-label text-md-end text-start">Quantity In stock</label>
                        <div class="col-md-6">
                          <input type="number" min="1" class="form-control @error('qty_in_stock') is-invalid @enderror" id="qty_in_stock" name="qty_in_stock" value="{{ old('qty_in_stock',$product->qty_in_stock) }}">
                            @if ($errors->has('qty_in_stock'))
                                <span class="text-danger">{{ $errors->first('qty_in_stock') }}</span>
                            @endif
                        </div>
                    </div>

                    <!--------------end-qty-stock---->

                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $product->description }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <!------category--------->
                    <div class="mb-3 row">
                        <label for="category" class="col-md-4 col-form-label text-md-end text-start">Category</label>
                        <div class="col-md-6">
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($categories as $category)
                                  <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endforeach
                              </select>
                            @if ($errors->has('category_id'))
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <!------end-category--------->

                    <!-------image-------------------->
                    <div class="mb-3 row">
                        <label for="image" class="col-md-4 col-form-label text-md-end text-start">Image</label>
                        <div class="col-md-6">
                            <input class="form-control @error('image') is-invalid @enderror" accept="image/*" type="file" name="image" id="formFile">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div>
                    <!--------end-image----------------------->
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection