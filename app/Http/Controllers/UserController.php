<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware("auth"); 
        $this->middleware("permission:create-user|edit-user|delete-user",["only"=>["index","show"]]);
        $this->middleware("permission:create-user",["only"=>["create","store"]]);
        $this->middleware("permission:edit-user",["only"=>["edit","update"]]);
        $this->middleware("permission:delete-user",["only"=>["destroy"]]); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::latest("id")->paginate(10);
        return view("users.index",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::pluck("name")->all();
        return view("users.create",compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $input = $request->all();
        $input["password"] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);
        //set value of verified_at field
        $user->markEmailAsVerified();

        return redirect()->route("users.index")->with("success","New user is added successfully.");

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return view("users.show",compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        if($user->hasRole("Super Admin")){
            if($user->id != auth()->user()->id){
                abort(403,"USER DOES NOT HAVE THE RIGHT PERMISSIONS.");
            }
        }

        return view("users.edit",[
            "user"=> $user ,
            "roles" => Role::pluck("name")->all(),
            "userRoles" => $user->roles->pluck("name")->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $input = $request->all();
        if(!empty($request->password)){
            $input["password"] = Hash::make($request->password);
        }else{
            $input = $request->except("password");
        }

        $user->update($input);
        $user->syncRoles($request->roles);

        return redirect()->back()->with("success","User is updated successfully.");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //Abort if user is Super Admin or user id belongs to logged in user
        if($user->hasRole("Super Admin") || $user->id == auth()->user()->id){  
          abort(403,"USER DOES NOT HAVE THE RIGHT PERMISSIONS");
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route("users.index")->with("success","User deleted successfully.");

    }
}
