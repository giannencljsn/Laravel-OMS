<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusLog;
use Faker\Factory as Faker;

class StatusLogSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            StatusLog::create([
                'order_id' => $faker->numberBetween(1, 100),
                'imei' => $faker->unique()->numerify('###############'),
                'new_status' => $faker->randomElement(['Shipped', 'Processing', 'Delivered', 'Cancelled']),
                'changed_at' => $faker->dateTimeThisYear(),
                'processed' => $faker->boolean(50),
            ]);
        }
    }
}
