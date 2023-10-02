@extends('layouts.admin')


@section('content')
    <div class="container">
        <div class="row mb-2 my-4 mx-2 d-flex align-items-center">
            <div class="col-12 text-center py-3">
                <h2 class="card-title fw-bold {{ strtolower(explode(' ', $sponsor->title)[1]) }} px-2 py-3 ">
                    <i class="fa-solid fa-star" style="color: #ffbc19;"></i>
                    Sponsorship {{ explode(' ', $sponsor->title)[1] }}
                    <i class="fa-solid fa-star" style="color: #ffbc19;"></i>
                </h2>
                <div class="">
                    <a href="{{ route('admin.sponsors.index') }}" class="back btn border border-black">
                        Torna indietro
                        <i class="fa-solid fa-rotate-left" style="color: #ffbc19;"></i>
                    </a>
                </div>
            </div>
        </div>

        <div id="sponsor_show" class="container h-100">
            <div class="row d-flex justify-content-center mb-5">
                <h4 class="my-3">Seleziona l'appartamento da sponsorizzare</h4>
                {{-- qui se più appartamenti --}}
                @if (isset($apartments))
                    @if (count($apartments) > 0)
                        {{-- tabella appartamenti --}}
                        <div class="col-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class=" d-md-table-cell p-3">
                                            <i class="fa-solid fa-house"></i>
                                            Appartamento
                                        </th>
                                        <th scope="col" class="p-3">
                                            <i class="fa-solid fa-tag"></i>
                                            Titolo
                                        </th>
                                        <th scope="col" class=" d-lg-table-cell p-3">
                                            <i class="fa-solid fa-location-dot"></i>
                                            Indirizzo
                                        </th>
                                        <th scope="col" class="text-center p-3">
                                            <i class="fa-solid fa-rocket"></i>
                                            Sponsorizza
                                        </th>
                                    </tr>
                                </thead>

                                @foreach ($apartments as $index => $apartment)
                                    <tbody>
                                        <tr>
                                            <td class="d-none d-md-table-cell align-middle">
                                                <div class="apartment-img-container">
                                                    <img src="{{ $apartment->full_path_main_img }}"
                                                        alt=" {{ $apartment->title }}" class="my-img img-fluid rounded">
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                {{ $apartment->title }}
                                            </td>
                                            <td class="d-none d-lg-table-cell align-middle">
                                                {{ $apartment->address }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('admin.payment.create', ['sponsor_id' => $sponsor->id, 'apartment_id' => $apartment->id]) }}"
                                                    class="text-decoration-none btn-sponsor border py-1 px-3 border-warning pay-hover hvr">
                                                    Seleziona
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <div class="col">
                            <div class="d-flex justify-content-center gap-3 align-items-center fs-4 mt-5">
                                <i class="fa-solid fa-building"></i>
                                <p class="m-0">Non ci sono appartamenti da poter sponzorizzare!</p>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Qui se appartamento singolo --}}
                    <div class="col-md-12 col-lg-6 d-flex justify-content-center">
                        <div class="my-card-special p-4">
                            <h2
                                class="card-title text-center fw-bold {{ strtolower(explode(' ', $sponsor->title)[1]) }} px-2 py-3 ">
                                {{ explode(' ', $sponsor->title)[1] }}</h2>
                            <h6 class="px-2 py-3 py-xxl-5 text-center">Prezzo: {{ $sponsor->price }} &euro;/h</h6>
                            <h6 class="px-2 py-3 py-xxl-5 text-center">Durata: {{ $sponsor->duration }} h</h6>
                            <p class="card-text p-2 text-center">{{ $sponsor->description }}</p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="my-card-special p-4">
                            <h2 class="text-center px-2 py-3">{{ $apartment->title }}</h2>
                            <div class="px-5 pt-5">
                                <img class="img-fluid rounded" src="{{ $apartment->full_path_main_img }}">
                            </div>
                            <div class="text-center my-3">
                                {{-- occhio alla rotta che adesso e admin.payment.create --}}
                                <a href="{{ route('admin.payment.token', ['sponsor_id' => $sponsor->id, 'apartment_id' => $apartment->id]) }}"
                                    class="secondary-btn">
                                    Procedi al pagamento
                                </a>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
