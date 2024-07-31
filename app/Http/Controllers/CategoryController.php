<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(){
       $this->middleware("auth");
       $this->middleware("permission:create-category|edit-category|delete-category", ["only"=> ["index","show"]]);
       $this->middleware("permission:create-category", ["only"=> ["create","store"]]);
       $this->middleware("permission:edit-category", ["only"=> ["edit","update"]]);
       $this->middleware("permission:delete-category", ["only"=> ["destroy"]]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $id = auth()->user()->id;   
        $categories = Category::where("user_id",$id)->orderBy("id","desc")->paginate(3);
        return view("categories.index",compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //show the categories view
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        $input = $request->all();
        $input["user_id"] = auth()->user()->id;
        //create the category
        Category::create($input);
        return redirect()->route("categories.index")->with("success","Category created successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view("categories.show",compact("category"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view("categories.edit",compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //get all inputs
        $input = $request->all();
        $input["user_id"] = auth()->user()->id;
        //update category
        $category->update($input);
        return redirect()->route("categories.index")->with("success","Category update successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->route("categories.index")->with("success","Category deleted successfully.");
    }
}
