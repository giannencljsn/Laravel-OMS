<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // default password
            'two_factor_secret' => Str::random(16),
            'two_factor_recovery_codes' => json_encode([Str::random(8), Str::random(8)]), // Example recovery codes
            'two_factor_confirmed_at' => now(),
            'remember_token' => Str::random(10),
            'current_team_id' => null, // or set a valid team id
            'profile_photo_path' => null, // set a valid path if you have one
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
