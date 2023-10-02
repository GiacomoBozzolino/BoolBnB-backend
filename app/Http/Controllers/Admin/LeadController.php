<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ApartmentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Lead;
use App\Models\Apartment;

use App\Mail\NewContact;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.leads.index', compact( 'leads', 'newDate'));  
    }

    public function show(Lead $lead, Apartment $apartament)
    {
        $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $lead->created_at) ->format('m/d/Y  H:i');
        // dd($newDate);
        
        return view('admin.leads.show', compact('lead', 'newDate'));
    }
}