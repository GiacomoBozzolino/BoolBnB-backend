@extends('layouts.admin')

@section('content')
    <div class="container" id="payment-container">
        <div class="row" id="payment-container">
            <div class="col-md-8 col-md-offset-2">
                <div id="dropin-container"></div>
                <button class="btn btn-primary" id="submit-button">Request payment method</button>
            </div>
  
        </div>
    </div>
    <div class="container d-none mt-5"  id="thank-you-message">
        <div class="row justify-content-center">
            <div class="col-8 text-center border-message p-5 pb-0" >
                <h1 class="text-success text center"><em>GRAZIE PER AVER EFFETTUATO IL PAGAMENTO</em></h1>
                <p class="text-success">Ora l'appartamento verrà sponsorizzato secondo il piano promozionale selezionato. Se stai riscontrando problemi con il pagamento della sponsorship ti preghiamo di contattare l'assistenza <a href="BoolBnbAssistenza@gmail.com">BoolBnbAssistenza@gmail.com</a></p>
                <button id="butt" class="btn btn-danger mt-3 "><a href="{{ route('admin.sponsors.index') }}" class="links-decor text-light">EXIT <i class="fa-solid fa-right-from-bracket fa-beat ps-2"></i></button>
                <h6 class="text-dark text-start pt-3"><i class="fa-solid fa-earth-europe"></i> BoolBnB ti ringrazia...</h6>
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
            container: '#dropin-container'
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
                        if (payload) {

                            
                            let container = document.getElementById("payment-container")

                            
                            let containerMessage = document.getElementById("thank-you-message")

                            // button.classList.add("d-none");

                            containerMessage.classList.remove('d-none')
                            // buttonReturn.classList.remove("d-none");


                            container.classList.add("d-none")
                    

                            
                        }

                    })
                    .catch(error => {
                        console.log('error', payload);
                        console.error(error);
                        if (payload) {

                            

                            let container = document.getElementById("payment-container")

                            
                            let containerMessage = document.getElementById("thank-you-message")

                            // button.classList.add("d-none");

                            containerMessage.classList.remove('d-none')
                            // buttonReturn.classList.remove("d-none");


                            container.classList.add("d-none")
                    

                            
                        }
                    });
                });
            });
        });
    </script>
  
@endsection
