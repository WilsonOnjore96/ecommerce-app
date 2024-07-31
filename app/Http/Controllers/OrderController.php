<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->middleware("permission:view-order|edit-order|delete-order", ["only"=> ["index","show"]]);
        $this->middleware("permission:edit-order", ["only"=> ["edit","update"]]);
        $this->middleware("permission:delete-order", ["only"=> ["destroy"]]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //select orders by user id
        $user_id = auth()->user()->id;  
        //merchant orders
        $merchant_orders = DB::table("orders")->join("products","products.id","=","orders.product_id")->select("orders.order_num")->groupBy("orders.order_num")->where("products.user_id",$user_id)->paginate(2);
        //customer orders
        $orders = DB::table("orders")->select("orders.order_num")->groupBy("orders.order_num")->where("orders.user_id",$user_id)->paginate(2);
        return view("orders.index", compact("orders","merchant_orders"));
    }


     /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        //get the orders for both customer and merchant
           $order_details = DB::table("orders")->join("users","users.id","=","orders.user_id")->select("orders.*","users.name")->where("order_num",$id)->paginate(2);
               return view("orders.show", [
            "order_details"=> $order_details
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
        return view("orders.edit", compact("order"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        $input = $request->all();
        $order->update($input);
        return redirect()->route("orders.index")->with("success","Order updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return redirect()->route("orders.index")->with("success","Order deleted successfully");
    }

   
}
