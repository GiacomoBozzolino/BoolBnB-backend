@extends('layouts.admin')

@section('content')
    <div class="mx-5">
        <div class="row">
            @if (isset($message))
                <div class="col-12 mt-5">
                    <div class="alert alert-success">
                        <span>{{ $message }}</span>
                    </div>
                </div>
            @endif
            <div class="col d-flex justify-content-center mt-5">
                <div class="card" style="width: 45rem;">
                    <img src="{{ asset('storage/' . $apartment->cover_img) }}" class="card-img-top" alt=""
                        width="600px">
                    <div class="card-body">
                        <p class="card-title">Titolo: <strong>{{ $apartment->title }}</strong></p>
                        <p class="card-text">Numero delle stanze: <strong>{{ $apartment->n_rooms }}</strong></p>
                        <p class="card-text">Numero stanze da letto: <strong>{{ $apartment->n_beds }}</strong></p>
                        <p class="card-text">Numero bagni: <strong>{{ $apartment->n_bathrooms }}</strong></p>
                        <p class="card-text">Metri quadri: <strong>{{ $apartment->square_meters }}</strong></p>
                        <p class="card-text">Visibilita:
                            @if ($apartment->visibility === 1)
                                <strong>Il tuo anuncio e visibile al pubblico</strong>
                            @else
                                <strong>Il tuo annuncio non e visibile al pubblico</strong>
                            @endif
                        </p>
                        <p class="card-text">Breve descrizione: <strong>{{ $apartment->description }}</strong></p>
                        <p class="card-text">Servizi: <strong>
                                <ul class="card-list list-unstyled ms-5">
                                    @if (count($apartment->services) > 0)
                                        @foreach ($apartment->services as $item)
                                            <li><?php echo $item->icon; ?> {{ $item->type }}</li>
                                        @endforeach
                                    @else
                                        <li>Non ci sono servizi inseriti</li>
                                    @endif
                                </ul>

                            </strong></p>
                        <a href="{{ Route('admin.apartments.index') }}" class="btn btn-primary">Back Home</a>
                        {{-- <p class="card-text"> {{ $posts->category->name }} </p> --}}
                        <div class="col-12">
                            {{-- <strong>Servizi</strong> --}}
                            {{-- DA INSERIRE TUTTI I SERVIZI A MO DI LABLE --}}


                            {{-- @if ($posts->technologies)
                                @foreach ($posts->technologies as $technology)
                                    <a href="" class="btn btn-sm btn-primary">{{ $technology->name }}</a>
                                @endforeach
                            @else
                                Non sono presenti tecnologie associate al progetto
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
