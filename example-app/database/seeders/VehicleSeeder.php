<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        // Create a Faker instance
        $faker = Faker::create();

        // Create 50 random vehicles
        foreach (range(1, 50) as $index) {
            Vehicle::create([
                'model' => $faker->word,  // Random word for the model (e.g., "Corolla")
                'brand' => $faker->company,  // Random company name for the brand (e.g., "Toyota")
                'year' => $faker->year,  // Random year (e.g., 2020)
            ]);
        }
    }
}
