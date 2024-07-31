<div class="card" style="overflow-x: auto;">
    <div class="card-header">Manage Orders</div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Order Num</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $order->order_num }}</td>
                        <td>  
                                <a href="{{ route('orders.show', $order->order_num) }}"
                                class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                        </td>
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
        

        {{ $orders->links() }}

    </div>
</div>