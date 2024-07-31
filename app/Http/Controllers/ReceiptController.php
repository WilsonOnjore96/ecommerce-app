<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

use Illuminate\Http\Request;


class ReceiptController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function generatePDF($invoice){
         $order = Order::where('order_num',$invoice)->get();

         $pdf = Pdf::loadView('orders/'.$order["order_num"]);
         
         return $pdf->download('receipt');
    }
}
