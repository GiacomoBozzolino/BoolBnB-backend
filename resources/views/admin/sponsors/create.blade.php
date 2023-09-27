@extends('layouts.admin')

@section('content')

<div class="container">
     <div class="row">
       <div class="col-md-8 col-md-offset-2">
         <div id="dropin-container"></div>
         <button id="submit-button">Request payment method</button>
       </div>
     </div>
</div>

<script src="https://js.braintreegateway.com/web/dropin/1.40.0/js/dropin.min.js"></script>

<script>

    let sponsor = "{{ $sponsors->first()->id }}";

    let apartment = "{{ $apartments->first()->id }}";

    const button = document.querySelector('#submit-button');
    braintree.dropin.create({
      authorization: '{{$token}}',
      container: '#dropin-container'
  }, function (createErr, instance) {
      button.addEventListener('click', function () {
        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
          if (requestPaymentMethodErr) {
            console.error(requestPaymentMethodErr);
            return;
          }
         
          const headers = new Headers({
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
});

// Dati da inviare


// Opzioni per la richiesta Fetch
const options = {
    method: 'GET',
    headers: headers,
    //body: JSON.stringify(payload) // Assumi che payload sia un oggetto da inviare come JSON
};

// URL della richiesta

const url = "{{ route('admin.sponsor.process') }}?code="+payload.nonce+"&sponsor_id="+sponsor+"&apartment_id="+apartment; // Assumi che questa parte sia nel tuo template blade


// Esegui la richiesta Fetch
fetch(url, options)
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nella richiesta');
        }
        return response.json(); // Parsa la risposta JSON, se necessario
    })
    .then(data => {
        console.log('success', payload);
    })
    .catch(error => {
        console.log('error', payload);
        console.error(error);
    });
        });
    });
  });
</script>

@endsection