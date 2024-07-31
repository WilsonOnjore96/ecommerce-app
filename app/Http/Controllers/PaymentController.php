<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
        $this->middleware("permission:view-payment|delete-payment",["only"=>["index","show"]]);
        $this->middleware("permission:delete-payment",["only"=>["destroy"]]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $logged_in_user = auth()->user()->id;
        $payments = Payment::where("user_id",$logged_in_user)->orderBy("id","desc")->paginate(5); 
        return view("payments.index",compact("payments"));
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
        return view("payments.show",compact("payment"));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //call the delete method
        $payment->delete();
        return redirect()->back()->with("success","Payment deleted successfully");
    }
}
