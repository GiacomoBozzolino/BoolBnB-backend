@extends('layouts.admin')

@section('content')
<div class="row row-cols-1 mb-2 my-4 mx-2">
    <div class="col py-3">
        <h2>
            <span class="icon-section me-2">
                <i class="fa-solid fa-chart-pie fa-sm" style="color: #EF7039;"></i>
            </span>
            Le Statistiche dei Miei Appartamenti:
        </h2>
    </div>
</div>

<div class="row my-4 mx-2">
    <div class="col">
        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col">
                        <i class="fa-solid fa-tag" style="color: #ffbc19;"></i>    
                        Titolo
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-location-dot" style="color: #ffbc19;"></i>
                        Indirizzo
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-star" style="color: #ffbc19;"></i>
                        Sponsorizzazione
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-chart-pie fa-sm" style="color: #ffbc19;"></i>
                        Dettaglio statistiche
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($userApartments as $apartment)
                <tr>
                    <td>{{ $apartment->title }}</td>
                    <td>{{ $apartment->address }}</td>
                    <td>
                        @if($apartment->sponsors()->where('start_at', '<=', now())->where('end_at', '>=', now())->count() > 0)
                            Attiva
                        @else
                            Non attiva
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.statistic.show', ['id' => $apartment->id]) }}" style="text-decoration: underline;">Mostra</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection