<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Carbon\Carbon;

class VisitorSeeder extends Seeder
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
            13, 14, 15, 16, 17, 18, 19,
        ];

        for ($i = 0; $i < 100; $i++) {
            $carbon = new Carbon();
            $between = $carbon->between('-10 years', 'now');
            $viewedAt = Carbon::now()->subDays(rand(1, 365))->subHours(rand(1, 24))->subMinutes(rand(1, 60))->format('Y-m-d H:i:s');

            $data = [
                'apartment_id' => $faker->randomElement($apartments),
                'ip_address' => $faker->ipv4,
                'viewed_at' => $viewedAt,
                'created_at' => $between,
                'updated_at' => $between,
            ];

            DB::table('visitors')->insertOrIgnore($data);
        }
    }
}