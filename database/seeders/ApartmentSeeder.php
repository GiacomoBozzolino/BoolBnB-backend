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
    public function run()
    {
        $apartments = config('apartments');

        foreach ($apartments as $item) {
            $apartment = new Apartment();
            $apartment->title = $item['title'];
            $apartment->slug = $apartment->generateSlug($item['title']);
            $apartment->n_rooms = $item['n_rooms'];
            $apartment->n_beds = $item['n_beds'];
            $apartment->n_bathrooms = $item['n_bathrooms'];
            $apartment->square_meters = $item['square_meters'];
            $apartment->address = $item['address'];
            $apartment->cover_img = $item['cover_img'];
            $apartment->latitude = $item['latitude'];
            $apartment->longitude = $item['longitude'];
            $apartment->description = $item['description'];
        
            $apartment->save();
        }
    }
}
