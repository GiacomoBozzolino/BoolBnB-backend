<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service; 

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'type'=>'Parcheggio ', 
                'icon'=>'<i class="fa-solid fa-square-parking"></i>'
            ],
            [
                'type'=>'Connessione Wifi Gratuita', 
                'icon'=>'<i class="fa-solid fa-wifi"></i>'
            ],
            [
                'type'=>'Ristorante', 
                'icon'=>'<i class="fa-solid fa-utensils"></i>'
            ],
            [
                'type'=>'Animali ammessi', 
                'icon'=>'<i class="fa-solid fa-paw"></i>'
            ],
            [
                'type'=>'Palestra', 
                'icon'=>'<i class="fa-solid fa-dumbbell"></i>'
            ],
            [
                'type'=>'Camere non fumatori', 
                'icon'=>'<i class="fa-solid fa-ban-smoking"></i>'
            ],
            [
                'type'=>'Spa & Centro benessere', 
                'icon'=>'<i class="fa-solid fa-spa"></i>'
            ],
            [
                'type'=>'Piscina', 
                'icon'=>'<i class="fa-solid fa-person-swimming"></i>'
            ],
            [
                'type'=>'Navetta Aeroportuale', 
                'icon'=>'<i class="fa-solid fa-van-shuttle"></i>'
            ],
            [
                'type'=>'Reception 24/7', 
                'icon'=>'<i class="fa-regular fa-clock"></i>'
            ],
        ];


        foreach ($data as $item) {
            $service = new Service();

            $service->type = $item['type'];
            $service->icon = $item['icon'];
            $service->save();

        }
    }
}
