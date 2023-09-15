<?php

namespace App\Http\Controllers\Admin;

// import
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Service;

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
        // funzione che genera lo slug
        $form_data['slug'] = $apartment->generateSlug($form_data['title']);


        $apartment->fill($form_data);
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

        $services = Service::all();

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
}
