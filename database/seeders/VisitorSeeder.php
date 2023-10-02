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
            1,3,4,19,20,21,22,
        ];

        // Elimina i dati esistenti nella tabella 'visitors'
        DB::table('visitors')->delete();

        for ($i = 0; $i < 100; $i++) {
            $viewedAt = $faker->dateTimeBetween('2023-01-01', '2023-09-30')->format('Y-m-d H:i:s');

            $data = [
                'apartment_id' => $faker->randomElement($apartments),
                'ip_address' => $faker->ipv4,
                'viewed_at' => $viewedAt,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            DB::table('visitors')->insert($data);
        }
    }
}