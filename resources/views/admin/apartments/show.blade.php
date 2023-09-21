@extends('layouts.admin')

@section('content')
    <div class="mx-5">
        <div class="row d-flex justify-content-center">
            @if (isset($message))
                <div class="col-12 mt-5">
                    <div class="alert alert-success">
                        <span>{{ $message }}</span>
                    </div>
                </div>
            @endif
            <div class="col-12 d-flex mt-5 position-relative">
                <div class="img-container">
                    <img src="{{ asset('storage/' . $apartment->cover_img) }}" class="card-img-top" alt="">
                </div>
                <div class="ms-5 ">
                    <div class="card-body">
                        {{-- titolo --}}
                        <p class="card-text badge text-bg-success">Titolo</p> <strong>{{ $apartment->title }}</strong> <br>
                        {{-- numeri stanze  --}}
                        <p class="card-text badge text-bg-success">Numero delle stanze</p>
                        <strong>{{ $apartment->n_rooms }}</strong><br>
                        {{-- numeri stanze da letto  --}}
                        <p class="card-text badge text-bg-success">Numero stanze da letto</p>
                        <strong>{{ $apartment->n_beds }}</strong><br>
                        {{-- numero bagni --}}
                        <p class="card-text badge text-bg-success">Numero bagni</p>
                        <strong>{{ $apartment->n_bathrooms }}</strong><br>
                        {{-- metri quadri --}}
                        <p class="card-text badge text-bg-success">Metri quadri</p>
                        <strong>{{ $apartment->square_meters }}</strong><br>
                        {{-- visibilita --}}
                        <p class="card-text badge text-bg-success">Visibilita</p>
                        @if ($apartment->visibility === 1)
                            <strong>Il tuo anuncio e visibile al pubblico</strong>
                        @else
                            <strong>Il tuo annuncio non e visibile al pubblico</strong>
                        @endif
                        <br>
                        {{-- descrizione --}}
                        <p class="card-text badge text-bg-success">Breve descrizione</p>
                        <strong>{{ $apartment->description }}</strong><br>
                        {{-- servizi --}}
                        <p class="card-text badge text-bg-success">Servizi</p>
                        <strong class="d-flex flex-wrap">
                            @if (count($apartment->services) > 0)
                                @foreach ($apartment->services as $item)
                                    <h5><span class="badge text-bg-primary rounded-pill m-1"><?php echo $item->icon; ?>
                                            {{ $item->type }}</span></h5>
                                @endforeach
                            @else
                                <h5><span class="badge text-bg-warning rounded-pill">Non ci sono servizi inseriti</span>
                                </h5>
                            @endif
                        </strong>
                        {{-- tasti con realtive sulla col-12 --}}

                        <div class="position-absolute top-0 end-0 me-5">
                            <a href="{{ Route('admin.apartments.index') }}" class="btn btn-primary"> <i
                                    class="fa-solid fa-house"></i> Back Home</a>
                            <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifica
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!--inizio mappa-->
            <div class="col-12 mt-5">

                <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.59.0/maps/maps-web.min.js"></script>
                <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />


                <div id="map" style="width: 100%; height: 500px;"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // CONFIGURAZIONE API KEY LAT E LONG
                        let apiKey = 'zXBjzKdSap3QJnfDcfFqd0Ame7xXpi1p';
                        let apartmentLat = {{ $apartment->latitude }};
                        let apartmentLgn = {{ $apartment->longitude }};
                        // CONFIGURAZIONE MAPPA 
                        let map = tt.map({
                            key: apiKey,
                            container: 'map',
                            center: [apartmentLgn, apartmentLat],
                            zoom: 13
                        });
                        // DATI MARKER
                        let markerHeight = 50;
                        let markerRadius = 10;
                        let linearOffset = 25;

                        let popupOffsets = {
                            'top': [0, 0],
                            'top-left': [0, 0],
                            'top-right': [0, 0],
                            'bottom': [0, -markerHeight],
                            'bottom-left': [linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
                            'bottom-right': [-linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
                            'left': [markerRadius, (markerHeight - markerRadius) * -1],
                            'right': [-markerRadius, (markerHeight - markerRadius) * -1]
                        };
                        // Aggiungi un gestore di eventi per il click sulla mappa
                        map.on('click', function(e) {
                            let popup = new tt.Popup({
                                    offset: popupOffsets,
                                    className: 'my-class'
                                })
                                .setLngLat(e.lngLat)
                                .setHTML("<span>{{ $apartment->address }}</span>")
                                .addTo(map);
                        });
                        let marker = new tt.Marker().setLngLat([apartmentLgn, apartmentLat]).addTo(map);
                    });
                </script>
            </div>
        </div>
           <!--fine mappa-->
              
        @foreach ($apartment->leads as $item)
            <ul>
                <li>
                    nome: {{ $item->name }}
                </li>
                <li>
                    Email del cliente: {{ $item->email }}
                </li>
                <li>
                    Messaggio: {{ $item->content }}
                </li>
                <li>
                    Inviato alle: {{$item->created_at}}
                </li>
            </ul>
        @endforeach
    </div>
@endsection
