@extends('layouts.admin')

@section('content')
    <div class="mx-5 py-5">
        <div class="row">
            <div class="col-12 text-center pb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">Aggiungi il tuo appartamento</h2>
                    
                </div>
            </div>
            <h6>Quando sul nome del campo si trova il seguente simbolo:<span class="text-danger"> *</span>. Significa che il campo deve essere compilato obbligatoriamente </h6>
            {{-- BANNER TUTTI MESSAGGI ERRORE --}}
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                        @endforeach
                    </ul>
                </div>        
            @endif --}}

            <div class="col-12 mb-5">
                <form action=" {{ Route('admin.apartments.store') }} " method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group p-4">
                        <ul class="list-unstyled">
                            <!-- Titolo -->
                            <li>
                                <label class="control-label my-2">Titolo</label>
                                <span class="text-danger"> *</span>
                                <input type="text" name="title" id="title" placeholder="Inserisci il titolo"
                                class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>

                            <!-- Numero stanze -->
                            <li>
                                <label class="control-label my-2">Numero delle stanze</label>
                                <span class="text-danger"> *</span>
                                <select class="form-control" name="n_rooms" id="n_rooms" required>
                                    <option value="" disabled selected>Seleziona il numero di stanze</option>
                                    @for ($i = 1; $i <= 9; $i++)
                                        <option value="{{ $i }}" @selected(old('n_rooms') == $i)>{{ $i }} </option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero stanze da letto -->
                            <li>
                                <label class="control-label my-2">Numero delle stanze da letto</label>
                                <span class="text-danger"> *</span>
                                <select class="form-control" name="n_beds" id="n_beds" required>
                                    <option value="" disabled selected>Seleziona il numero di stanze da letto</option>
                                    @for ($i = 1; $i <= 9; $i++)
                                        <option value="{{$i}}" @selected(old('n_beds') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero bagni -->
                            <li>
                                <label class="control-label my-2">Numero bagni</label>
                                <span class="text-danger"> *</span>
                                <select class="form-control" name="n_bathrooms" id="n_bathrooms" required>
                                    <option value="" disabled selected>Seleziona il numero di bagni</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected(old('n_bathrooms') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Servizi -->
                            <li>
                                <label class="control-label my-2">Seleziona i servizi</label>
                                <span class="text-danger"> *</span>
                                <ul class="list-group d-flex flex-row flex-wrap justify-content-evenly my-3 ">
                                    @foreach ($services as $item)
                                        <li class="list-group-item col-5 d-flex align-items-center  @error('services') is-invalid @enderror">
                                            <input type="checkbox" name="services[]" value="{{ $item->id }}"
                                                class="form-check-input me-4"
                                                {{ in_array($item->id, old('services', [])) ? 'checked' : '' }} >
                                            <label class="control-label my-2 text-capitalize" ><?php echo $item->icon; ?>
                                                {{ $item->type }}</label>
                                        </li>
                                        
                                    @endforeach
                                    @error('services')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </ul>
                            </li>

                            <!-- Cover Image -->
                            <li>
                                <label for="" class="control-label mb-3">
                                    Immagine
                                </label>
                                <span class="text-danger"> *</span>
                                <input class="ps-3 @error('cover_img') is-invalid @enderror form-control" type="file" id="cover_img" name="cover_img" value="{{old('cover_img')}}" required>
                                @error('cover_img')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>

                            <!-- Metratura appartamento -->
                            <li>
                                <label class="control-label my-2">Inserisci la metratura</label>
                                <span class="text-danger"> *</span>
                                <input type="number" name="square_meters" id="square_meters"
                                    placeholder="Inserisci la metratura del tuo locale" class="form-control" min="1"
                                    max="249" required value="{{old('square_meters')}}">
                            </li>

                            <!-- Indirizzo -->
                            <li>
                                <label class="control-label my-2">Inserisci il tuo indirizzo</label>
                                <span class="text-danger"> *</span>
                                <input type="text" name="address" id="autocomplete-address" placeholder="Inserisci il tuo indirizzo" value="{{old('address')}}"
                                class="form-control @error('address') is-invalid @enderror" required>

                                <div id="address-results">
                                    <!--inserimento risultati in tempo reale-->
                                </div>

                                <div id="address-error" class="text-danger"></div>

                                <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.59.0/maps/maps-web.min.js"></script>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var addressInput = document.getElementById('autocomplete-address');
                                        var resultsContainer = document.getElementById('address-results');
                                        var errorContainer = document.getElementById('address-error');

                                        addressInput.addEventListener('input', function(){
                                            let searchValue = addressInput.value;

                                            //richiesta AJAX
                                            fetch('https://api.tomtom.com/search/2/search/'+searchValue+'.json?key=zXBjzKdSap3QJnfDcfFqd0Ame7xXpi1p&language=it-IT&idxSets=Str&countrySet=IT&typeahead=true')
                                            .then(response => response.json())
                                            .then(data => {
                                                resultsContainer.innerHTML = ''; //cancella i risultati precedenti

                                                if (data.results && data.results.length > 0) {
                                                    data.results.forEach(result => {
                                                        let resultItem = document.createElement('div');
                                                        resultItem.textContent = result.address.freeformAddress; //mostra il risultato
                                                        resultItem.classList.add('address-result-item');
                                                        resultsContainer.appendChild(resultItem);
                                                    });
                                                    errorContainer.textContent = ''; // Cancella il messaggio di errore se presente
                                                } else {
                                                    errorContainer.textContent = 'Nessun risultato trovato. Inserisci un indirizzo valido.';
                                                }
                                            });
                                        });

                                        // click sui risultiti 
                                        resultsContainer.addEventListener('click', function(event) {
                                            if (event.target && event.target.tagName == 'DIV') {
                                                var selectedAddress = event.target.textContent;
                                                addressInput.value = selectedAddress;
                                                addressInput.focus(); //focus su input
                                                resultsContainer.innerHTML = ''; //svuoto i risultati proposti 
                                                document.activeElement.blur(); //simula il click fuori dall'area dei risultati
                                            }
                                        });
                                    });
                                </script>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </li>

                            <!-- Visibilità -->
                            <li>
                                <label class="control-label my-2">Rendi visibile il tuo annuncio</label>
                                <span class="text-danger"> *</span>
                                <div class="radio-container d-flex">
                                    {{-- parte del si  --}}
                                    <div class="yes-container">
                                        <input type="radio" id="yes" name="visibility" value="1" {{old('visibility', '1') == '1' ? 'checked' : ''}} >
                                        <label for="yes">Sì, rendi l'annuncio visibile</label>
                                    </div>
                                    {{-- parte del no --}}
                                    <div class="no-container ms-5">
                                        <input type="radio" id="no" name="visibility" value="0" {{old('visibility') == '0' ? 'checked' : ''}}>
                                        <label for="no">No, non rendere l'annuncio visibile</label>
                                    </div>
                                </div>
                            </li>

                            <!-- Descrizione -->
                            <li>
                                <label class="control-label my-2">Descrizione</label>
                                <span class="text-danger"> *</span>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required> {{old('description')}}
                                </textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </li>

                            <!-- Submit Button -->
                            <li class="text-center my-5">
                                <button type="submit" class="btn btn-success">Aggiungi</button>
                                <a href="{{ Route('admin.apartments.index') }}" class="btn btn-danger">Annulla</a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
