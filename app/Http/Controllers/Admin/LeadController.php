<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;
use App\Mail\NewContact;
use App\Models\Apartment;
use Carbon\Carbon;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Admin\ApartmentController;

class LeadController extends Controller
{
    //CREO LA FUNZIONE STORE

    public function index(Request $request)
    {
        // $leads = Lead::all();
        $leads = DB::table('leads')->orderBy('created_at', 'desc')->get();
        
        $user = Lead::first();
        $newDate = $user->created_at->format('d-m-Y');
        
        // dd($newDate);
        
        // $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $leads->created_at)
        // ->format('m/d/Y');
        // dd($newDate);
    
        return view('admin.leads.index', compact( 'leads', 'newDate'));
       
        
    }


    public function show(Lead $lead, Apartment $apartament)
    {

        
        
        
        
        $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $lead->created_at)
                                    ->format('m/d/Y');
        // dd($newDate);
        
        return view('admin.leads.show', compact('lead', 'newDate'));
    }


            
      
}