<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


// Importo il model di Apartment

use App\Models\Apartment;
use App\Models\Service;

class ApartmentController extends Controller
{   
    public function index()
    {
        $apartments = Apartment::with('services')->where('visibility',1)->get();

        return response()->json([
            'success' => true,
            'results' => $apartments
        ]);
    }


    public function show ($slug){
        $apartment =Apartment::with('services')->where('slug', $slug)->first();

        if($apartment){
            return response()->json([
                'success' => true,
                'apartment' => $apartment,
            ]);
        }

        else{
            return response()->json([
                'success' => false,
                'error' => 'nessun post trovato',
            ]);
        }
    }

    // CHIAMATA API SPOSORIZZAZIONI
    public function getFeaturedApartments()
    {
        $apartments = Apartment::with('sponsors')->get();

        return response()->json($apartments);
    }



    // FUNZIONE DI RICERCA BASE
    public function search(Request $request)
    {
        $city = $request->input('city');

        $url = 'https://api.tomtom.com/search/2/geocode/' . urlencode($city) . '.json';
        $apiKey = 'zXBjzKdSap3QJnfDcfFqd0Ame7xXpi1p';

        // api key: 
        // Eugerniu ---> hThUeWOkuwn7VZV1hYMz1TA6KlJr6vsL
        // Brusa ---> zXBjzKdSap3QJnfDcfFqd0Ame7xXpi1p

        $response = Http::get($url, [
            'key' => $apiKey
        ]);
        
        $data = json_decode($response->getBody());

        // Estrai le coordinate dalla risposta
        $coordinates = $data->results[0]->position;

        // Aggiorna il modello di appartamento con le coordinate
        $apartmentLatitude = $coordinates->lat;
        $apartmentLongitude = $coordinates->lon;

        // Calcola la distanza in chilometri (utilizzando la formula Haversine)
    $distance = 20; // Raggio in chilometri

    $apartments = Apartment::select('apartments.*')
    ->selectRaw(
        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
        [$apartmentLatitude, $apartmentLongitude, $apartmentLatitude]
    )
    ->leftJoin('apartment_sponsors', 'apartments.id', '=', 'apartment_sponsors.apartment_id')
    ->where('visibility', 1)
    ->having('distance', '<', $distance)
    ->orderByRaw('CASE WHEN apartment_sponsors.apartment_id IS NOT NULL THEN 0 ELSE 1 END, apartment_sponsors.end_at DESC, distance')
    ->get();

        return response()->json($apartments);
    }


    // FUNZIONE DI RICERCA AVANZATA
    public function searchAdvanced(Request $request)
    {
        $city = $request->input('city');

        $url = 'https://api.tomtom.com/search/2/geocode/' . urlencode($city) . '.json';
        $apiKey = 'aFDJe2bs8IDU6bZxos4ruOdBhXWHbbAr';

        $response = Http::get($url, [
            'key' => $apiKey
        ]);
        
        $data = json_decode($response->getBody());

        // Estrai le coordinate dalla risposta
        $coordinates = $data->results[0]->position;

        // Aggiorna il modello di appartamento con le coordinate
        $apartmentLatitude = $coordinates->lat;
        $apartmentLongitude = $coordinates->lon;

        // Calcola la distanza in chilometri (utilizzando la formula Haversine)
    $distance = $request->input ('distance'); // Raggio in chilometri
    $n_rooms = $request->input('n_rooms');
    $n_beds = $request->input('n_beds');
    $selectedServices = $request->input('services', []);



    $apartments = Apartment::select('apartments.*')
    ->selectRaw(
        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
        [$apartmentLatitude, $apartmentLongitude, $apartmentLatitude]
    )
    ->leftJoin('apartment_sponsors', 'apartments.id', '=', 'apartment_sponsors.apartment_id')
    ->where('visibility', 1)
    ->having('distance', '<', $distance)
    
    ->where('n_rooms', '>=', $n_rooms)
    ->where('n_beds', '>=', $n_beds)
    ->orderByRaw('CASE WHEN apartment_sponsors.apartment_id IS NOT NULL THEN 0 ELSE 1 END, apartment_sponsors.end_at DESC, distance');

    if ($selectedServices) {
     foreach ($selectedServices as $serviceId) {
        $apartments->whereHas('services', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        });
    }
    }   

    $apartments = $apartments->get();
        return response()->json($apartments);
    }
    
}


    