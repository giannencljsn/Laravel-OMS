<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [   
                'name' => 'Phoneville Mobile Inc',
                'email' => 'phonevillemobile@test.gmail.com',
                'password' => bcrypt('yourpassword'),
                'address' => '123 Anywhere St.',
                'store_assigned' => $storeAssignedId,
                'role' => 'Superadmin',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
