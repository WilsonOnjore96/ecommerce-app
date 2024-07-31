<?php

use App\Http\Controllers\Payments\PaystackController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Payments\StripeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//route for the new arrivals and home page
Route::get('/', function () {
    $products = Product::orderBy('id','desc')->paginate(8);
    return view('welcome',compact("products"));
})->name("welcome");

//route to show all produsts
Route::get('/store',function(){
    $products = Product::orderBy('id','desc')->paginate(10);
    $categories = Category::orderBy('id','desc')->paginate(4); 
    return view('store',compact('categories','products'));
})->name('store');


//search for product;
Route::post('/store',function(Request $req){
       $input = $req->only('name');
       $name = $input['name'];
       $categories = Category::orderBy('id','desc')->paginate(4); 
       $products = Product::where('name','LIKE', '%'.$name.'%')->get();
       return view('store',compact('products','categories'));

})->name('search');


//get product based on category name
Route::get('/store/product-category/{id}',function($id){
     $products = DB::table('categories')->join('products','products.category_id','=','categories.id')->select('products.*','categories.id')->where('categories.id',$id)->get();
     $categories = Category::orderBy('id','desc')->paginate(4); 
     return view('store',compact('categories','products'));
})->name('product-category');

//get product by id
Route::get('/product-details/{id}',function($id){
    $product = Product::findOrFail($id);
    return view("product_details",compact("product"));
})->name('product-details');


//download receipt
Route::get('generate-pdf',[ReceiptController::class,'generatePDF'])->name('generate-pdf');


//Forgot Password Routes
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


//Cart Routes
Route::get("/cart",[CartController::class,"index"])->name("cart");
Route::get("/add-to-cart/{id}",[CartController::class,"addToCart"])->name("addtocart");
Route::post("/product-details/{id}",[CartController::class,"store"])->name("cart-store");
Route::delete("remove-from-cart",[CartController::class,"delete"])->name("remove_from_cart");
Route::patch("update-cart",[CartController::class,"update"])->name("update_cart");

//Stripe Payment routes
Route::post("/session",[StripeController::class,"session"])->name("session");
Route::get("/success",[StripeController::class,"success"])->name("success");
Route::get("/cancel",[StripeController::class,"cancel"])->name("cancel");

//Paystack Payment Routes

Route::post("/paystack_payment",[PaystackController::class,"makePayment"])->name("paystack-payment");
Route::get("/paystack_success",[PaystackController::class,"success"])->name("paystack-success");   
Route::get("/paystack_cancel",[PaystackController::class,"cancel"])->name("paystack-cancel");


Route::get("paystack-test",function(){
    return view("paystack");
})->name("paystack-test");
//Other routes

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resources([
     "roles"=>RoleController::class,
     "users"=>UserController::class,
     "products"=>ProductController::class,
     "categories"=>CategoryController::class,
     "orders"=>OrderController::class,  
     "payments"=>PaymentController::class,
]);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
