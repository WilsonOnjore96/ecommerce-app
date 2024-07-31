@extends('layouts.app')

@section('content')
   
            <div class="card" style="overflow-x: auto;">
                <div class="card-header">Manage Payments</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">S#</th>
                                <th scope="col">Pay ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Status</th>
                                <th scope="col">Method</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                {{ $payment->payment_id }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->currency }}</td>
                                    <td><span class="badge bg-primary">{{ $payment->payment_status }}</span></td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('payments.show', $payment->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                            @can('delete-payment')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this user?');"><i
                                                    class="bi bi-trash"></i> Delete</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <td colspan="5">
                                    <span class="text-danger">
                                        <strong>No Payments Found!</strong>
                                    </span>
                                </td>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $payments->links() }}

                </div>
            </div>
        
@endsection
