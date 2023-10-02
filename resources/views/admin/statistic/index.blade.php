@extends('layouts.admin')

@section('content')
<div class="row row-cols-1 mb-2 my-4 mx-2">
    <div class="col py-3">
        <h1>
            <span class="icon-section me-2">
                <i class="fa-solid fa-chart-pie fa-sm"></i>
            </span>
            Le statistiche dei miei appartamenti:
        </h1>
    </div>
</div>

<div class="row my-4 mx-2">
    <div class="col">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <i class="fa-solid fa-tag"></i>    
                        Titolo
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-location-dot"></i>
                        Indirizzo
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-sack-dollar"></i>
                        Sponsorizzazione
                    </th>
                    <th scope="col">
                        <i class="fa-solid fa-chart-pie fa-sm"></i>
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