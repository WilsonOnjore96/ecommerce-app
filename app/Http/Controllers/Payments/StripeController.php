<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Order;


class StripeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("permission:create-payment", ["only" => ["session"]]);
    }
    //create payment session
    public function session()
    {
        $user = auth()->user();


        $productItems = [];
        //\Stripe\Stripe::setApiKey(config("stripe.sk"));
        $stripe = new \Stripe\StripeClient(config("stripe.sk"));

        if (empty(session("cart"))) {
            return redirect()->route("cart")->with("success", "Cart cannot be empty");
        } else {
            //loop through the cart session
            foreach (session('cart') as $id => $details) {
                $product_name = $details['product_name'];
                $total = $details["product_price"];
                $quantity = $details["product_quantity"];
                $two0 = "00";
                $unit_amount = "$total$two0";

                $productItems[] = [
                    "price_data" => [
                        "product_data" => [
                            "name" => $product_name,
                        ],
                        "currency" => "USD",
                        "unit_amount" => $unit_amount,
                    ],
                    "quantity" => $quantity,
                ];

            }


            // $response = \Stripe\Checkout\Session::create([
            $response = $stripe->checkout->sessions->create([
                'line_items' => [$productItems],
                'mode' => 'payment',
                'allow_promotion_codes' => true,
                'metadata' => [
                    'user_id' => $user->id, //logged in user
                ],
                'customer_email' => "onjorew@gmail.com", //$user->email,
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);


        }
        //the checkout session is the response
        //dd($response);
        //check if its an actual user
        if (isset($response->id) && $response->id != '') {
            return redirect($response->url)->with('success','Payment successful');
        } else {
            return redirect()->route('cancel');
        }

    }


    //success url
    public function success(Request $request)
    {
        $user = auth()->user();
        $order_num = IdGenerator::generate(['table' => 'orders', 'field' => 'order_num', 'length' => 10, 'prefix' => "INV-"]); 
        ;
        if (isset($request->session_id)) {
            //access stripe client
            $stripe = new \Stripe\StripeClient(config("stripe.sk"));
            //retrieve data from the stripe session
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            //insert orders
            if ((session('cart'))) {
                foreach (session('cart') as $id => $details) {
                    Order::create([
                        "user_id" => $user->id,
                        "product_id" => $details["product_id"],
                        "order_num" => $order_num,
                        "order_item_name" => $details["product_name"],
                        "order_item_price" => $details["product_price"],
                        "order_item_qty" => $details["product_quantity"],
                        "order_item_cost" => $details["product_quantity"] * $details["product_price"],
                        "order_status"=>"Pending"
                    ]);
                }
            }

            //add data to payments table

            Payment::create([
                "payment_id" => $response->id,
                "amount" => $response->amount_subtotal / 100,
                "currency" => $response->currency,
                "payment_status" => $response->status,
                "order_num" => $order_num,
                "user_id" => $user->id,
                "payment_method" => "Stripe",
            ]);

            //clear cart
            session()->forget("cart");

            return view("payments_success");

        } else {
            return redirect()->route('cancel');

        }
    }

    //cancel url
    public function cancel()
    {
        return view('payments_cancel');
    }

}
