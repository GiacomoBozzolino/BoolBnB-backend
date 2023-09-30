@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="dropin-container"></div>
                <button class="btn btn-primary" id="submit-button">Paga</button>
            </div>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.40.0/js/dropin.min.js"></script>

    <script>
        let urlParams = new URLSearchParams(window.location.search);
        let sponsor = urlParams.get('sponsor_id');
        let apartment = urlParams.get('apartment_id');

        const button = document.querySelector('#submit-button');
        
        braintree.dropin.create({
            authorization: '{{ $token }}',
            container: '#dropin-container',
            locale: 'it_IT',
        }, function(createErr, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                    if (requestPaymentMethodErr) {
                        console.error(requestPaymentMethodErr);
                        return;
                    }

                    const headers = new Headers({
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    });

                    // URL della richiesta
                    let url = "{{ route('admin.sponsor.process') }}?code=" + payload.nonce +
                        "&sponsor_id=" + sponsor + "&apartment_id=" + apartment;

                    // Esegui la richiesta Fetch
                    fetch(url, {
                        method: 'GET',
                        headers: headers
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Errore nella richiesta');
                        }
                        return response.json();
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
