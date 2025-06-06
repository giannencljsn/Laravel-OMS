<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
     

DB::table('users')->insert([
    [   
        'name'=>'SuperAdmin',
        'username' => 'superadminuser',
        'photo' => 'superadminphoto.jpg',
        'phone' => '09123456701',
        'address' => '123 Superadmin St., Supercity, Superprovince',
        'store_assigned' => null, // Superadmin may not be assigned to any store
        'role' => 'Superadmin',
        'status' => 'Active',
        'email' => 'superadmin@example.com',
        'password' => bcrypt('superadminpassword123')
    ],
    [
        'name'=>'Admin',
        'username' => 'adminuser',
        'photo' => 'adminphoto.jpg',
        'phone' => '09123456702',
        'address' => '456 Admin St., Admincity, Adminprovince',
        'store_assigned' => 1, // Store ID 1, assuming it exists in the 'phoneville_branches' table
        'role' => 'Admin',
        'status' => 'Active',
        'email' => 'admin@example.com',
        'password' => bcrypt('adminpassword123')
    ],
    [
        'name'=>'Store Staff',
        'username' => 'storestaffuser',
        'photo' => 'storestaffphoto.jpg',
        'phone' => '09123456703',
        'address' => '789 Store Staff St., Storecity, Storeprovince',
        'store_assigned' => 2, // Store ID 2, assuming it exists in the 'phoneville_branches' table
        'role' => 'Store_Staff',
        'status' => 'Active',
        'email' => 'storestaff@example.com',
        'password' => bcrypt('storestaffpassword123')
    ]
]);

    }
}
