<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;  

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //assign permissions to role
        //first create the roles
        Role::create(["name"=>'Super Admin']);
        $admin = Role::create(['name'=> 'Admin']);
        $merchant = Role::create(['name'=> 'Merchant']);
        $customer = Role::create(['name'=> 'Customer']);

        //assigning permissions to the roles
       $admin->givePermissionTo([
           'create-user',
           'edit-user',
           'delete-user',
           'create-category',
           'edit-category',
           'delete-category',
           'create-product',
           'edit-product',
           'delete-product',
           'view-order',
           'edit-order',
           'delete-order',
           'view-payment',
           
       ]);

       $merchant->givePermissionTo([
        'create-product',
        'edit-product',
        'delete-product',
        'view-order',
        'edit-order',
        'delete-order',
        'view-payment',
       ]);

       $customer->givePermissionTo([
        'view-order',
        'edit-order',
        'delete-order',
        'create-payment',
        'view-payment',
       ]);

    }
}
