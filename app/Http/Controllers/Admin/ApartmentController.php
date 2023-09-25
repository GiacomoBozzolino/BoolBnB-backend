<?php

namespace App\Http\Controllers\Admin;

// import
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Service;
use TomTom\Telematics\Endpoints\Geocoding\GeocodeQuery;
use GuzzleHttp\Client;
use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

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
        // DARE ID UTENTI A APPARTAMENTI
        $apartments = auth()->user()->apartments;





        


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
        $services = Service::all();

        return view('admin.apartments.create', compact('apartments', 'services'));
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
        // DARE ID UTENTI A APPARTAMENTI
        $apartment->user_id = auth()->user()->id;

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

        if($request->has('services')){
            $apartment->services()->attach($request->services);
        }  
        $message = 'Appartamento aggiunto con successo!';
        return redirect()->route('admin.apartments.index', compact('apartment', 'message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Apartment $apartment, )
    {
        $message = $request->query->get('message');


        // $user_id = auth()->user()->id;
       
        $user = auth()->user();
        // dd($user->apartments);

        

        

        // CONTROLLO SE, IL APPARTAMENTO CHE MI è STATO PASSATO, CORRISPONDE AL APPARTAMENTO COLLEGATO ALL'UTENTE ATTUALMENTE AUTENTICATO
        if ($user->apartments->contains($apartment)){

            // RITORNO LA SHOW DEL APARTMENT
            return view('admin.apartments.show', compact('apartment'));
           
           

        } else {

            // RIMANDO L'UTENTE NELLA PAGINA DI PARTENZA
            return redirect()->route('admin.apartments.index', compact('apartment'));
        }



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
        

        $services = Service::all();


        $user = auth()->user();
        // dd($user->apartments);

        

        

        // CONTROLLO SE, IL APPARTAMENTO CHE MI è STATO PASSATO, CORRISPONDE AL APPARTAMENTO COLLEGATO ALL'UTENTE ATTUALMENTE AUTENTICATO
        if ($user->apartments->contains($apartment)){

            // RITORNO LA SHOW DEL APARTMENT
            return view('admin.apartments.edit', compact('apartment', 'services'));
           
           

        } else {

            // RIMANDO L'UTENTE NELLA PAGINA DI PARTENZA
            return redirect()->route('admin.apartments.index', compact('apartment', 'services'));
        }


        return view('admin.apartments.edit', compact('apartment', 'services'));
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
        

        $form_data['slug'] = Str::slug($form_data['title'], '-');

        $apartment->update($form_data);

        if($request->has('services')){
            $apartment->services()->sync($request->services);
        }  

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

    public function searchAddress(Request $request)
    {
        $searchTerm = $request->input('address');
        $apiKey = 'zXBjzKdSap3QJnfDcfFqd0Ame7xXpi1p';

        //ricerca degli indirizzi con tom tom 
        $query = GeocodeQuery::create($searchTerm)->withMaxResults(10);
        $results = $this->performTomTomGeocoding($query, $apiKey);

        return response()->json(['results' => $results]);
    }

    public function saveAddress(Request $request)
    {
        $selectedAddress = $request->input('selected_address');
    }

    private function performTomTomGeocoding($query, $apiKey)
{
    $client = new Client();
    $response = $client->get("https://api.tomtom.com/search/2/search/{$query}.json", [
        'query' => [
            'key' => $apiKey,
        ],
    ]);

    $data = json_decode($response->getBody());

    // Estrai i risultati o le informazioni necessarie dalla risposta
    $results = $data->results;

    return $results;
}
}
