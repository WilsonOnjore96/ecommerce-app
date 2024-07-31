<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
           'create-role',
           'edit-role',
           'delete-role',
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
           'create-payment',
           'view-payment',
           'delete-payment',
        ];

        //looping and inserting array's permission into permission table
        foreach($permissions as $permission){
            Permission::create(['name'=>$permission]);    
        }
    }
}
