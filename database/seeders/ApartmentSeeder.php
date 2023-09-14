<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Faker\Generator as Faker;
use Faker\Provider\en_US\Address;
class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=1; $i <11 ; $i++) {
            $apartment= new Apartment(); 
            $apartment->title= $faker -> sentence(3);
            $apartment->slug=$apartment->generateSlug($apartment->title);
            $apartment->n_rooms= $faker ->randomDigit();
            $apartment->n_beds= $faker ->randomDigit();
            $apartment->n_bathrooms= $faker ->randomDigit();
            $apartment->square_meters= $faker ->numberBetween(40,250);
            $apartment->address= $faker -> streetAddress();
            $apartment->cover_img= $faker -> imageUrl(640,480,'city', true);
            $apartment->latitude= $faker -> latitude();
            $apartment->longitude= $faker -> longitude();
            $apartment->visibility= $faker -> boolean();
            $apartment->description= $faker -> paragraph(2);
        

            $apartment->save();
  
        }
    }
}
