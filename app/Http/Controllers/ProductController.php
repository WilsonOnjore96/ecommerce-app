<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    public function __construct(){
      $this->middleware("auth");
      $this->middleware("permission:create-product|edit-product|delete-product",["only"=>["index","show"]]);
      $this->middleware("permission:create-product",["only"=>["create","store"]]);
      $this->middleware("permission:edit-product",["only"=>["edit","update"]]);
      $this->middleware("permission:delete-product",["only"=>["destroy"]]);    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $id =  auth()->user()->id;  
        $products = Product::where("user_id", $id)->orderBy("id","desc")->paginate(10);
        return view("products.index",compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view("products.create",compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //get all products submitted
        $input = $request->all();
        $input["user_id"] = auth()->user()->id; 
        $input["category_id"] = (int) $request->category_id;
        //dd($input);
        
        if($image = $request->file("image")){
            $path = 'public/images';
            $filename =  $filename =  date('YmdHis').".".$image->getClientOriginalExtension();
            $image->storeAs($path,$filename);
            $input["image"] = $filename;    
        }

        Product::create($input);
        return redirect()->route("products.index")->with("success","Product created successfully.");
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product_has_category = Product::join("categories","categories.id","=","products.category_id")
                                       ->select("categories.name")
                                       ->where("products.id",$product->id)
                                       ->get();

        return view("products.show",compact("product","product_has_category"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();  
        return view("products.edit",compact("product","categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //remove the previous images
        if(Storage::exists('public/images/'.$product->image)){
            //we delete the current image in the db
           Storage::delete('public/images/'.$product->image);
        } 

        $input = $request->all();
        $input["user_id"] = auth()->user()->id;
        $input["category_id"] = (int) $request->category_id;


        if($image = $request->file("image")) {
            $path = 'public/images';
            $filename =  date('YmdHis').".".$image->getClientOriginalExtension();
            $image->storeAs($path,$filename);
            $input["image"] = $filename;    
        }else{
            unset($input["image"]);
        }

        //now update product
        $product->update($input);
        return redirect()->route("products.index")->with("success","Product updated successfully.");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //remove the previous images
        if(Storage::exists('public/images/'.$product->image)){
            //we delete the current image in the db
           Storage::delete('public/images/'.$product->image);
        } 

        $product->delete();
        return redirect()->route("products.index")->with("success","Product deleted successfully.");
    }

    
}
