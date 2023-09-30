<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Sponsor;
use App\Models\ApartmentSponsor;

use Braintree_Transaction;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $sponsor_id = $request->input('sponsor_id');
        
        $apartment_id = $request->input('apartment_id');

        $nonce = $request->input('code', false);

        $sponsor = Sponsor::find($sponsor_id);
       
        //$nonce = $payload['nonce'];

        $gateway = new \Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env("BRAINTREE_MERCHANT_ID"),
            'publicKey' => env("BRAINTREE_PUBLIC_KEY"),
            'privateKey' => env("BRAINTREE_PRIVATE_KEY")
        ]);

        $status = $gateway->transaction()->sale([
            'amount' => $sponsor->price,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        $apartmentSponsor = ApartmentSponsor::create([
            'apartment_id' => $apartment_id,
            'sponsor_id' => $sponsor_id,
            'start_at' => now(),
            'end_at' => now()->addHours($sponsor->duration),
        ]);

        return response()->json($status);
    }

    public function create(Request $request)
    {
        $sponsors = Sponsor::all();

        $apartments = auth()->user()->apartments;

        $gateway = new \Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env("BRAINTREE_MERCHANT_ID"),
            'publicKey' => env("BRAINTREE_PUBLIC_KEY"),
            'privateKey' => env("BRAINTREE_PRIVATE_KEY")
        ]);

        $clientToken = $gateway->clientToken()->generate();
        
        return view('admin.sponsors.create', [
            'token' => $clientToken,
            'sponsors' => $sponsors,
            'apartments' => $apartments,
        ]);
    }
}
