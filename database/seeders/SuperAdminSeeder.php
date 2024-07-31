<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;    

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $superAdmin = User::create([
            "name"=> "John Doe",
            "email"=>"john@gmail.com",
            "password"=> Hash::make("john1234")
        ]);
        $superAdmin->assignRole("Super Admin");
        $superAdmin->markEmailAsVerified();

        $admin = User::create([
          "name"=> "Mary Jane",
          "email"=>"mary@gmail.com",
          "password"=>Hash::make("mary1234")
        ]);
        $admin->assignRole("Admin");
        //sets the email verified at value after user creation
        $admin->markEmailAsVerified();

        $merchant = User::create([
            "name"=> "Tresor Mputu",
            "email"=> "mputu@gmail.com",
            "password"=> Hash::make("mputu1234")
        ]);
        

        $merchant->assignRole("Merchant");
        //sets the email verified at value after user creation
        $merchant->markEmailAsVerified();


        $customer = User::create([
            "name"=> "Rainford Kalaba",
            "email"=> "kalaba@gmail.com",
            "password"=> Hash::make("Kalaba2020")
        ]);
        $customer->assignRole("Customer");
        $customer->markEmailAsVerified();
    }
}
