<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title'=>'required|max:50',
            'n_rooms'=>'required',
            'n_beds'=>'required',
            'n_bathrooms'=>'required',
            'square_meters'=>'required',
            'address'=>'required|max:250',
            'visibility'=>'required',
            'description'=>'required',
            'cover_img'=>'required|image',
            'services'=>'required|exists:services,id'
            
        ];
        
    }
    public function messages()
    {
        return [

            'title.required'=>'ERRORE: il titolo e obbligatorio',
            'title.max'=>'ERRORE: il titolo supera il limite di caratteri consentito 50',
            'n_rooms.required'=>'ERRORE: il numero di stanze è obbligatorio',
            'n_beds.required'=>'ERRORE: il numero di letti è obbligatorio',
            'n_bathrooms.required'=>'ERRORE: il numero di bagni è obbligatorio',
            'square_meters'=>'ERRORE: il numero di metri quadrati è obbligatorio',
            'address.required'=>'ERRORE: l indirizzo dell appartamento è obbligatorio',
            'address.max'=>'ERRORE: l indirizzo dell appartamento non deve essere lungo più di 250 caratteri',
            'visibility.required'=>'ERRORE: specificare se rendere visibile o nascosto l annuncio',
            'description.required'=>'ERRORE: la descrizione è obbligatoria',
            'cover_img.image'=>'ERRORE: assicurati che il file caricato sia in formato png, jpeg, jpg, webpg',
            'cover_img.required'=>'ERRORE: è obbligatorio caricare un immagine',
            'services.exists'=>'Seleziona un servizio valido',
            'services.required'=>'inserisci almeno un servizio',

        ];
    }

}
