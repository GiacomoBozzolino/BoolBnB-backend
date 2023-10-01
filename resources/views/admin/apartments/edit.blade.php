@extends('layouts.admin')

@section('content')
    <div class="mx-5 py-5">
        <div class="row">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold">Modifica il tuo appartamento</h2>
                </div>
            </div>
            
            <div class="col-12 mb-5">
                <form action=" {{ Route('admin.apartments.update', $apartment->id) }} " method="POST" enctype="multipart/form-data" autocomplete="off">
                    {{-- TOKEN --}}
                    @csrf
                    {{-- METHOD PUT --}}
                    @method('PUT')
                    <div class="form-group p-4">
                        <ul class="list-unstyled">

                            <!-- Titolo -->
                            <li>
                                <label class="control-label my-2">Titolo</label>
                                <input type="text" name="title" id="title" placeholder="Inserisci un titolo per il tuo annuncio"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $apartment->title }}" required>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </li>

                            <!-- Numero stanze -->
                            <li>
                                <label class="control-label my-2">Stanze</label>
                                <select class="form-control " name="n_rooms" id="n_rooms" required>
                                    
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option {{ $i == old('n_rooms', $apartment->n_rooms) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero tanze da letto -->
                            <li>
                                <label class="control-label my-2">Posti letto</label>
                                <select class="form-control" name="n_beds" id="n_beds" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                    <option {{ $i == old('n_beds', $apartment->n_beds) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Numero bagni -->
                            <li>
                                <label class="control-label my-2">Bagni</label>
                                <select class="form-control" name="n_bathrooms" id="n_bathrooms" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                    <option {{ $i == old('n_bathrooms', $apartment->n_bathrooms) ? 'selected': '' }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <!-- Servizi -->
                            <li>
                                <label class="control-label mt-4">Servizi aggiuntivi</label>
                                <ul class="list-group d-flex flex-row flex-wrap justify-content-evenly my-3">

                                    @foreach ($services as $item)
                                        <li class="list-group-item col-5 d-flex align-items-center">
                                            @if($errors->any())
                                                <input type="checkbox" name="services[]" value="{{ $item->id }}"
                                                class="form-check-input me-4 @error('services') is-invalid @enderror" {{in_array($item->id, old ('services', []))? 'checked': ''}}>
                                            @else
                                            <input type="checkbox" name="services[]" value="{{ $item->id }}"
                                                class="form-check-input me-4" {{$apartment->services->contains($item)? 'checked': ''}}>
                                            @endif

                                            <label class="control-label my-2"><?php echo $item->icon; ?>
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
                                <label for="" class="control-label mb-3">Immagine</label>
                                <div class="my-2">
                                    <img width="50%" src="{{ asset('storage/' . $apartment->cover_img) }}"
                                        alt="">
                                </div>
                                <input class="ps-3 form-control @error('cover_img') is-invalid @enderror" type="file" id="cover_img" name="cover_img"
                                    value="{{old('cover_img')?? $apartment->cover_img}}">
                                   
                                @error('cover_img')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                
                            </li>

                            <!-- Metratura appartamento -->
                            <li>
                                <label class="control-label my-2">Metratura</label>
                                <input type="number" name="square_meters" id="square_meters"
                                    placeholder="Inserisci la metratura del tuo appartamento" class="form-control @error('square_meters') is-invalid @enderror" min="1"
                                    max="249" value="{{ old('square_meters') ?? $apartment->square_meters }}"
                                    required>
                                    @error('square_meters')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </li>

                            <!-- Indrizzo -->
                            <li>
                                <label class="control-label my-2">Indirizzo</label>
                                <span class="text-danger"> *</span>
                                <input type="text" name="address" id="autocomplete-address" placeholder="Inserisci l'indirizzo" value="{{ old('address') ?? $apartment->address }}"
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
                                                let button = document.querySelector('.btn')
                                                if (data.results && data.results.length > 0) {
                                                    data.results.forEach(result => {
                                                        let resultItem = document.createElement('div');
                                                        resultItem.textContent = result.address.freeformAddress; //mostra il risultato
                                                        resultItem.classList.add('address-result-item');
                                                        resultsContainer.appendChild(resultItem);
                                                    });
                                                    button.disabled = false
                                                    errorContainer.textContent = ''; // Cancella il messaggio di errore se presente
                                                    
                                                } else {
                                                    errorContainer.textContent = 'Nessun risultato trovato. Inserisci un indirizzo valido.';
                                                    button.disabled = true
                                                    
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

                            <!-- Visibili -->
                            <li>
                                <label class="control-label my-2">Visibilità</label>
                                <div class="radio-container d-flex">
                                    {{-- parte del si  --}}
                                    <div class="yes-container">
                                        <input type="radio" id="yes" name="visibility" value="1" {{  old('visibility', '1') == '1' ? 'checked' : ''}} >
                                        {{-- <input type="radio" id="yes" name="visibility" value="1"
                                            {{ $apartment->visibility == 1 ? 'checked' : '' }}> --}}
                                        <label for="yes">Rendi visibile l'annuncio</label>
                                    </div>
                                    {{-- parte del no --}}
                                    <div class="no-container ms-5">
                                        <input type="radio" id="no" name="visibility" value="0" {{old('visibility') == '0' ? 'checked' : ''}}>
                                        {{-- <input type="radio" id="no" name="visibility" value="0"
                                            {{ $apartment->visibility == 0 ? 'checked' : '' }}> --}}
                                        <label for="no">Nascondi l'annuncio</label>
                                    </div>
                                </div>
                            </li>

                            <!-- Descrizione -->
                            <li>
                                <div class="form-group">
                                    <label class="control-label my-2">Descrizione</label>
                                    <textarea name="description" id="description" class="text-start form-control @error('address') is-invalid @enderror"
                                        required>{{ old('description') ?? $apartment->description }}
                                    </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </li>

                            <!-- Submit Button -->
                            <li class="text-center my-5">
                                <button type="submit" class="btn btn-success">Salva</button>
                                <a href="{{ Route('admin.apartments.index') }}" class="btn btn-danger">Anulla</a>
                            </li>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
