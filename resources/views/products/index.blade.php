@extends('layouts.app')

@section('content')

<div class="col-md-10 m-auto" style="overflow-x: auto;">
    
        <h2 class="text-center">Product List</h2>
        @can('create-product')
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Product</a>
        @endcan
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Stock</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->qty_in_stock }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                            @can('edit-product')
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-product')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');"><i class="bi bi-trash"></i> Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="4">
                        <span class="text-danger">
                            <strong>No Product Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $products->links() }}

    
</div>
@endsection