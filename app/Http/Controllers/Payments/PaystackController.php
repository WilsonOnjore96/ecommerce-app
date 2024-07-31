<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Order;

class PaystackController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("permission:create-payment", ["only" => ["makePayment"]]);
    }
    //


    //function thet handles the payment request
    public function makePayment(Request $req)
    {
        $formData = [
            "email" => "onjorew@gmail.com",
            "amount" => $req->amount * 100,
            "callback_url" => route("paystack-success"),
        ];

        $pay = json_decode($this->initializePayment($formData));
        //dd($pay);
        if ($pay) {
            if ($pay->status) {
                //dd($pay);
                //if no error go to paystack
                return redirect($pay->data->authorization_url);
            } else {
                return back()->withSuccess($pay->message);
            }


        } else {
            return back()->withSuccess("Check if internet connection is available");
        }

    }

    //Define the request to be sent to paystack
    public function initializePayment($formData)
    {

        $secret_key = env("PAYSTACK_SECRET_KEY");

        //dd($fields);  
        $url = "https://api.paystack.co/transaction/initialize";
        $fields_string = http_build_query($formData);
        //dd($fields_string);
        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: Bearer " . $secret_key,
                "Cache-Control: no-cache",
            )
        );

        //So that curl_exec returns the contents of the cURL; rather than echoing it

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }



    public function success()
    {
        $user = auth()->user();
        $order_num = IdGenerator::generate(['table' => 'orders', 'field' => 'order_num', 'length' => 10, 'prefix' => "INV-"]);
        ;
        //obtain referrence value from the url
        //used to obtain response from paystack
        $response = json_decode($this->verifyPayment(request("reference")));
        //dd($response);
        //
        if ($response) {
            if ($response->status) {
                $data = $response->data;
                //dd($data);
                //now add the data to the payments table
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
                            "order_status" => "Pending"
                        ]);
                    }
                }

                //add data to payments table

                Payment::create([
                    "payment_id" => $data->id,
                    "amount" => $data->amount / 100,
                    "currency" => $data->currency,
                    "payment_status" => $data->status,
                    "order_num" => $order_num,
                    "user_id" => $user->id,
                    "payment_method" => "PayStack",
                ]);

                //clear cart
                session()->forget("cart");

                return view("payments_success");
            } else {
                return back()->with("success",$response->message);
            }
        } else {
            return back()->with("error","Something is wrong");
        }
    }

    public function cancel()
    {

        return view("payments_cancel");
    }


    public function getCartItems()
    {
        $productItems = [];

        foreach (session('cart') as $id => $details) {
            $product_name = $details['product_name'];
            $total = $details["product_price"];
            $quantity = $details["product_quantity"];
            $two0 = "00";
            $unit_amount = "$total$two0";

            $productItems[] = [
                'email' => "onjorew@gmail.com",
                'amount' => $unit_amount,
            ];
        }

        return $productItems;

    }

    public function verifyPayment($reference)
    {
        //initialize the secret key
        $secret_key = env("PAYSTACK_SECRET_KEY");
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . $secret_key,
                    "Cache-Control: no-cache",
                ),
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

}

