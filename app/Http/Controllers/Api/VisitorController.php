<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor; // Modifica il modello da 'view' a 'Visitor'
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function store(Request $request)
    {
        // Ottieni l'indirizzo IP e l'ID dell'appartamento dalla richiesta
        $ip_address = $request->ip_address;
        $apartment_id = $request->apartment_id;

        // Verifica se esiste già una visualizzazione con lo stesso IP e ID dell'appartamento
        $existingView = Visitor::where('ip_address', $ip_address)
            ->where('apartment_id', $apartment_id)
            ->first();

        if ($existingView) {
            return response()->json([
                'success' => false,
                'message' => 'View already exists',
                'data' => null
            ]);
        }

        // Crea una nuova istanza di Visitor
        $view = new Visitor();

        // Imposta l'indirizzo IP e l'ID dell'appartamento
        $view->ip_address = $ip_address;
        $view->apartment_id = $apartment_id;

        // Salva la visualizzazione nel database
        $view->save();

        return response()->json([
            'success' => true,
            'message' => 'View created',
            'data' => $view
        ]);
    }
}
