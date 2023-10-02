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
            <div class="mt-5">
                <div class="col-12 d-flex justify-content-between justify-content-center me-5 mb-3 p-2 text-capitalize">
                    <h2>I miei appartamenti
                        <i class="fa-solid fa-house-user" style="color: #EF7039;"></i>
                    </h2>
                    <div class="button-container">
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-color btn-outline-warning">
                            <strong>Aggiungi Appartamento</strong> 
                        </a>
                    </div>
                </div>
                <div class=" col-12 rounded-4 border border-2 p-4 shadow overflow-auto" style="height: 900px">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>Visibile</th>
                                <th>Titolo</th>
                                <th>Indirizzo</th>
                                <th>Servizi</th>
                                <th>Sponsorizzazioni</th>
                                <th>Scadenza</th>
                                <th>Strumenti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($apartments) && count($apartments) > 0)
                                @foreach ($apartments as $apartment)

                                
                                    <tr>
                                        {{-- Visibilita anuncio --}}
                                        <td>
                                            @if ($apartment->visibility === 1)
                                                <strong><span class="badge text-bg-success">On-Line</span></strong>
                                            @else
                                                <strong><span class="badge text-bg-danger">Off-Line</span></strong>
                                            @endif
                                        </td>
                                        {{-- TITOLO APARTAMENTO --}}
                                        <td>
                                            <h6 class="">{{ $apartment->title }}</h6>
                                        </td>
                                        {{-- Indirizzo --}}
                                        <td>
                                            <span><i class="fa-solid fa-location-dot"></i> {{ $apartment->address }}</span>
                                        </td>
                                        {{-- Servizi --}}
                                        <td>

                                            @foreach ($apartment->services as $item)
                                                <?php echo $item->icon; ?>
                                            @endforeach

                                        </td>
                                        {{-- Sposorizzazione --}}
                                        <td>
                                            @php
                                                $latestSponsor = null;
                                            @endphp

                                            @foreach ($apartment->sponsors as $sponsor)
                                                @if (now() <= $sponsor->pivot->end_at &&
                                                        (is_null($latestSponsor) || $sponsor->pivot->end_at > $latestSponsor->pivot->end_at))
                                                    @php
                                                        $latestSponsor = $sponsor;
                                                    @endphp
                                                @endif
                                            @endforeach

                                        @if (!is_null($latestSponsor))
                                            <i class="fas fa-star"></i> <span>{{ $latestSponsor->title }}</span> <i
                                                class="fas fa-star"></i>
                                        @else
                                            <p>Non Attive</p>
                                        @endif
                                    </td>
                                    {{-- Termine sposorizzazione --}}
                                    <td>
                                        @php
                                            $latestSponsor = null;
                                        @endphp

                                            @foreach ($apartment->sponsors as $sponsor)
                                                @if (now() <= $sponsor->pivot->end_at &&
                                                        (is_null($latestSponsor) || $sponsor->pivot->end_at > $latestSponsor->pivot->end_at))
                                                    @php
                                                        $latestSponsor = $sponsor;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @if (!is_null($latestSponsor))
                                                {{-- <span>Fino al {{ $sponsor->pivot->end_at }}</span> --}}
                                                @php
                                                    $formatDate = \Carbon\Carbon::parse($sponsor->pivot->end_at);
                                                @endphp
                                                @if (  $formatDate instanceof \Carbon\Carbon)
                                                
                                                    {{ $formatDate->format('d/m/Y') }} 
                                                
                                                @else
                                                    <td>Data non valida</td>
                                                    
                                                @endif
                                            @else
                                                <p><i class="fa-solid fa-minus"></i><i class="fa-solid fa-minus"></i><i
                                                        class="fa-solid fa-minus"></i></p>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div>
                                                    <a href="{{ route('admin.apartments.show', $apartment->id) }}"
                                                        class="btn mx-1 rounded-5 btn-show">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>

                                                <div>
                                                    <a href="{{ route('admin.apartments.edit', $apartment->id) }}"
                                                        class="btn rounded-5 btn-modify">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>

                                                <div>
                                                    <form
                                                        class="apartment-delete-button d-inline-block mx-1 btn-delete rounded-5"
                                                        data-apartment-title="{{ $apartment->title }}"
                                                        action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn ">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach     
                            @else
                            <div class="container-fluid border-message mb-5">
                                <div class="col-12 d-flex justify-content-center">
                                    <h1 class="p-5 pb-0"><em>NON CI SONO APPARTAMENTI....</em> <i class="text-danger text-center fa-solid fa-face-sad-tear fa-bounce"></i> </h1>
                                    
                                </div>
                                <div class="col-12 d-flex justify-content-center pb-3">
                                    {{-- <p>Pubblica un appartamento e comincia il tuo business</p> --}}
                                    <p>Clicca su aggiungi un nuovo appartamento e compila tutti i campi..</p>
                                </div>
                            </div>
                                
                                
                                   
                            @endif
                               

                        </tbody>
                    </table>
                    {{-- CARDS --}}
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.modal_apartment_delete')
    {{-- @include('admin.partials.modal_delete') --}}
@endsection
