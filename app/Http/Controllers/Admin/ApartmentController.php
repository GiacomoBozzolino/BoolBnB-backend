<?php

namespace App\Http\Controllers\Admin;

// import
use Illuminate\Support\Facades\Storage;

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
    public function index()
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
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
        $apartment->save();

        return redirect()->route('admin.apartments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
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

        return redirect()->route('admin.apartments.show', compact('apartment'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        // da creare la modale ~~~~~~~~~~



        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }
}
