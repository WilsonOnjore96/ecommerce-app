<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("cart");
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $product = Product::find($id);
        $input = $request->only("qty");
        $cart = session()->get('cart',[]);
        if(isset($cart[$id])){
            $cart[$id]['product_quantity']=$request->qty;
        }else{
           $cart[$id] = [
            'product_name'=> $product->name,
            'product_price'=> $product->price,
            'product_photo'=>$product->image,
            'product_id'=> $product->id,
            'product_quantity'=> $request->qty,
           ];
        }
        
        session()->put('cart', $cart);
        // dd($cart);
        return redirect()->route("cart")->with("success","Item added to cart successfully");

    }


    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        if($request->id && $request->quantity){
            $cart = session()->get("cart");
            $cart[$request->id]["product_quantity"] = $request->quantity;
            session()->put("cart",$cart);
            session()->flash("success","Cart successfully updated");
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        //
        if($request->id){
            $cart = session()->get("cart");
            if(isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put("cart", $cart);
            }
            session()->flash("success","Products successfully removed!");
        }
    }

    //function to add products to cart
    public function addToCart($id){
        $product = Product::findOrFail($id);
        $cart = session()->get('cart',[]);
        if(isset($cart[$id])){
            $cart[$id]['product_quantity']++;
        }else{
           $cart[$id] = [
            'product_name'=> $product->name,
            'product_price'=> $product->price,
            'product_photo'=>$product->image,
            'product_id'=> $product->id,
            'product_quantity'=> 1,
           ];
        }
        //add the created cart into the session variable
        session()->put('cart', $cart);

        //dd($cart);
        return redirect()->back()->with("success","Item added to cart successfully");
    }
}
