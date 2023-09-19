<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Importo il model di Apartment

use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('services')->get();

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
}
