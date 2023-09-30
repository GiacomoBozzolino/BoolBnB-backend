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
    public function index(Request $request)
    {
                return view('admin.leads.index', compact( 'leads', 'newDate'));  
    }

    public function show(Lead $lead, Apartment $apartament)
    {
        $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $lead->created_at)->format('m/d/Y');
        // dd($newDate);
        
        return view('admin.leads.show', compact('lead', 'newDate'));
    }
}