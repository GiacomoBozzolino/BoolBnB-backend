<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $apartments = [
            13,14,15,16,17,18,19,
        ];
        
        for ($i = 0; $i < 100; $i++) {
            $createdAt = $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d H:i:s');
        
            $data = [
                'name' => $faker->unique()->name(50),
                'email' => $faker->unique()->safeEmail(150),
                'content' => $faker->unique()->text(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
                'apartment_id' => $faker->randomElement($apartments),
            ];
        
            DB::table('leads')->insert($data);
        }
    }
}