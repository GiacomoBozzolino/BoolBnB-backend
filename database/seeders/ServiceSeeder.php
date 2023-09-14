<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use App\Models\Service; 

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=1; $i <11 ; $i++) {
            $service= new Service(); 
            $service->type= $faker -> word();
            $service->icon= $faker -> word();
            

            $service->save();
        }
    }
}
