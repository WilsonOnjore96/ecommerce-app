<div class="dropdown">
    
    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" > <i class="bi bi-cart4"></i><span id="cart-text">Cart</span> <span class="badge text-bg-warning text-white">{{ count((array) session('cart'))}}</span>
    </a>
    <div class="dropdown-menu">
       <div class="row total-header-section">
            @php $total = 0 @endphp
            @foreach((array) session('cart') as $id => $details)
                @php $total += $details["product_price"] * $details["product_quantity"] @endphp
            @endforeach
            <div class="col-lg-12 col-sm-12 col-12 total-section text-start">
                <p>Total :<span class="text-succss">{{ $total }}</span></p>
            </div>
       </div>

       @if(session('cart'))  
         @foreach((array) session('cart') as $id => $details)
       <div class="row cart-detail">
           <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <img src="{{ asset("storage/images/".$details['product_photo'])}}" alt="">
           </div>
           <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                <p>{{ $details["product_name"]}}</p>
                <span class="price text-success"> {{ $details["product_price"] }} </span> <span class="count"> Quantity:{{ $details["product_quantity"] }} </span>
           </div>
       </div>
         @endforeach
       @endif

       <div class="row">
            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                <a href="{{ route("cart")}}" class="btn btn-primary btn-block">View All</a>
            </div>
       </div>
    </div>
</div>