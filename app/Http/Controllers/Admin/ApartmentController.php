<?php

namespace App\Http\Controllers\Admin;

// import
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $message = $request->query->get('message');

        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartments = Apartment::all();

        return view('admin.apartments.create', compact('apartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        $form_data = $request->all();
        // controllo per aggiornare l'imagine
        if($request->hasFile('cover_img')){
            $path = Storage::put('apartments_img', $request->cover_img);
            $form_data['cover_img']=$path;
        }

        $apartment = new Apartment();
        // funzione che genera lo slug
        $form_data['slug'] = $apartment->generateSlug($form_data['title']);

        $apartment->fill($form_data);

        // Nuova logica per la conversione dell'indirizzo in coordinate
        $address = $request->input('address');
        
        $client = new Client();
        $response = $client->get("https://api.tomtom.com/search/2/geocode/{$address}.json", [
            'query' => [
                'key' => config('services.tomtom.key'), // Leggi la chiave API dalla configurazione
            ],
        ]);

        $data = json_decode($response->getBody());

        // Estrai le coordinate dalla risposta
        $coordinates = $data->results[0]->position;

        // Aggiorna il modello di appartamento con le coordinate
        $apartment->latitude = $coordinates->lat;
        $apartment->longitude = $coordinates->lon;
        
        $apartment->save();

        $message = 'Appartamento aggiunto con successo!';

        return redirect()->route('admin.apartments.index', compact('apartment', 'message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Apartment $apartment)
    {
        $message = $request->query->get('message');

        return view('admin.apartments.show', compact('apartment', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApartmentRequest  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $form_data = $request->all();
        // controllo per aggiornare l'imagine
        if($request->hasFile('cover_img')){
            $path = Storage::put('apartments_img', $request->cover_img);

            $form_data['cover_img']=$path;
        }

        $apartment->update($form_data);

        $message = 'Modifiche Appartamento Completata';

        return redirect()->route('admin.apartments.show', compact('apartment', 'message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        
        $apartment->delete();

        $message = 'Appartamento rimosso dal tuo account!';

        return redirect()->route('admin.apartments.index', compact('message'));
    }
}
