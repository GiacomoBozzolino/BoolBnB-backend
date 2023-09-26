<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                "title"=> "Promozione Base",
                "price"=> "2.99",
                "duration"=> "24",
                "description" => "Ottieni visibilità immediata per il tuo appartamento per 24 ore. Perfetto per aumentare le probabilità di essere notato dagli inquilini!"
            ],
            [
                "title"=> "Promozione Standard",
                "price"=> "5.99",
                "duration"=> "72",
                "description" => "Massima esposizione per 3 giorni (72 ore). Posiziona il tuo appartamento in prima fila nelle ricerche e cattura l'attenzione degli affittuari interessati!"
            ],
            [
                "title"=> "Promozione Premium",
                "price"=> "9.99",
                "duration"=> "144",
                "description" => "Passa ad un livello superiore con 6 giorni (144 ore) di promozione. Fai in modo che il tuo annuncio spicchi tra gli altri e aumenta le tue possibilità di affitto!"
            ],
        ];

        foreach ($sponsors as $key => $sponsor) {
            Sponsor::create($sponsor);
        }
    }
}
