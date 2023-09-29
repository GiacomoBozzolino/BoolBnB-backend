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
            <div class="col-12 d-flex mt-5 position-relative shadow border p-4 rounded-4">
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

                        <div class="position-absolute top-0 end-0 me-5 mt-3">
                            <a href="{{ Route('admin.apartments.index') }}" class="btn btn-primary"> <i
                                    class="fa-solid fa-house"></i> Back Home</a>
                            <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifica
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Inizio messaggi --}}
            <div class="col-6 border mt-5 rounded-4 shadow ">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Messaggio</th>
                            <th scope="col">Data Invio</th>
                            <th scope="col">Orario</th>                            
                            <th scope="col">Strumenti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartment->leads as $item)
                            <tr>

                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="text-truncate" style="max-width: 100px;">{{ $item->content }}</td>

                                @if ($apartment->created_at instanceof \Carbon\Carbon)
                                    <td>{{ $apartment->created_at->format('d/m/Y') }}</td>
                                @else
                                    <td>Data non valida</td>
                                @endif          

                                @if ($apartment->created_at instanceof \Carbon\Carbon)
                                    <td>{{ $apartment->created_at->format('H:i') }}</td>
                                @else
                                    <td>Data non valida</td>
                                @endif                  

                                <td>
                                    <div class="d-flex justify-content-center pt-3">
                                        <a href="{{ route('admin.leads.show', $item->id) }}"
                                            class="btn btn-sm mx-1 rounded-5 btn-show">
                                            <i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!--inizio mappa-->
            <div class="col-6 mt-5 shadow ">
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
    </div>
@endsection
