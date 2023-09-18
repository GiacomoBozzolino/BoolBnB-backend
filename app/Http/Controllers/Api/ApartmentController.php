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
        $apartments = Apartment::all();

        return response()->json([
            'success' => true,
            'results' => $apartments
        ]);
    }
}
