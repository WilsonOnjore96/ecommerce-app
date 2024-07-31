@extends("layouts.app")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-9">
            
        <h2 class="text-center" style="font-weight:bold;">Cart</h2>
            
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @if(session('cart'))
                       @foreach (session('cart') as $id => $details)
                         @php $total += $details["product_quantity"] * $details["product_price"] @endphp
                        <tr data-id="{{ $id }}">
                            <td data-th="S#">{{ $loop->iteration }}</td>
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-2 hidden-xs">
                                        <img src="{{ asset("storage/images/".$details["product_photo"])}}" width="50" height="50" class="img-responsive">
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $details['product_name'] }}</p>
                                    </div>
                                </div>
                            </td> 
                            
                            <td data-th="Price">
                                {{ $details["product_price"]}}
                            </td>
                            
                            <td data-th="Quantity">
                                <input type="number" value="{{ $details['product_quantity']}}" class="form-control quantity cart_update" min="1"/>
                            </td>    

                            <td data-th="Subtotal">
                                {{ $details["product_price"] * $details["product_quantity"]}}
                            </td>
                            <td class="actions" data-th="Action">
                                <button class="btn btn-danger btn-sm cart_remove"><i class="bi bi-trash"></i>Delete</button>
                            </td>    

                        </tr>
                       @endforeach
                       @else
                       <td colspan="4">
                          <span class="text-danger">
                              <strong>No Product Found!</strong>
                           </span>
                       </td>
                    @endif
                </tbody>
                <tfoot>
                      <tr>
                        <td colspan="6" style="text-align:right;"><h3><strong>Total: {{ $total }}</strong></h3></td>
                      </tr>
                      <tr>
                        <td colspan="6" style="text-align:right">
                            <!---<form action=" route('session')}} " method="POST">
                                <a href=" url('/')}}" class="btn btn-danger"><i class="bi bi-arrow-right-circle"></i> Continue Shopping</a>
                                <input type="hidden" name="_token" value=" csrf_token()}}">
                                <button  class="btn btn-success" type="submit" id="checkout-live-button"><i class="bi bi-cash-coin"></i> Checkout </button>
                            </form>--->
                           
                            <form action="{{ route('paystack-payment')}}" method="POST">
                                 @csrf
                                 <a href="{{ url('/')}}" class="btn btn-dark"><i class="bi bi-arrow-right-circle"></i> Continue Shopping</a>
                                 @if(session('cart'))
                                 <input type="hidden" name="amount" value="{{ $total}}">
                                 <button  class="btn btn-warning" type="submit" id="checkout-live-button"><i class="bi bi-cash-coin"></i> Checkout </button>
                                 @endif
                            </form>
                        </td>
                      </tr>   
                </tfoot>    
            </table>
        
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    $('.cart_remove').click(function (e){
        e.preventDefault();
        
        var ele = $(this);

        if(confirm("Do you really want to remove?")){
            //alert("Success");
           
            $.ajax({
             url: "{{ route('remove_from_cart') }}",
             method: "DELETE",
             data: {
                _token :'{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id")
             },
             success: function(response){
                window.location.reload();
             }
           });
        }
    });

    $('.cart_update').click(function (e){
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: "{{ route('update_cart') }}",
            method: "PATCH",
            data : {
                _token: "{{ csrf_token() }}",
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function(response){
                window.location.reload();
            }
        })
        
    });
</script>

@endsection