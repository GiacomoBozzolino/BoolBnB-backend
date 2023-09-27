<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;
use App\Mail\NewContact;
use App\Models\Apartment;
use App\Http\Controllers\Admin\ApartmentController;

class LeadController extends Controller
{
    //CREO LA FUNZIONE STORE

    public function index(Request $request)
    {
        $leads = Lead::all();

        return view('admin.leads.index', compact('leads'));
       
        
    }


    public function show(Lead $lead, Apartment $apartament)
    {

        $apartament = Apartment::all();
        
        return view('admin.leads.show', compact('lead'));
    }


            
      
}