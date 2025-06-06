<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pickupTime = Carbon::createFromFormat('h:i:s A', '09:38:48 AM')->format('H:i:s');
        DB::table('orders')->insert([
            [
                'order_id' => 'ORDER#10148',
                'invoice_id' => '78996afe-2849-417e-ab77-473db5d706b0',
                'branch_id' => 1, // Assuming you have a branch with ID 1
                'status' => 'forpickup',
                'imei' => '355116322974507',
                'stock_available' => 1,
                'availability' => 'Nov 2 at 12:00 PM',
                'pickup_date' => now()->addDay(),
                'pickup_time' => $pickupTime,
                'pickup_code' => 'TQoO4KVNH3dG',
                'customer_email' => 'sbridgerton5@gmail.com',
                'customer_number' => '09568170208',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
