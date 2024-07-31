@extends('layouts.app')

@section('content')
<div class="card" style="overflow-x: auto;">
    <div class="card-header">Orders
        <div class="float-end">
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Order Num</th>
                    <th scope="col">Order By</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order_details as $odd)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $odd->order_num }}</td>
                        <td>{{ $odd->name }}</td>
                        <td>{{ $odd->order_item_name }}</td>
                        <td>{{ $odd->order_item_price }}</td>
                        <td>{{ $odd->order_item_qty }}</td>
                        <td>{{ $odd->order_item_price * $odd->order_item_qty }}</td>
                        <td> <span class="badge bg-primary">{{ $odd->order_status }}</span></td>

                        <td>{{ $odd->created_at }}</td>
                </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No Orders Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $order_details->links() }}

    </div>
</div>
@endsection
