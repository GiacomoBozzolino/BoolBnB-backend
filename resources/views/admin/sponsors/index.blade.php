@extends('layouts.admin')

@section('content')
    <div class="row row-cols-1 mb-5 my-4 mx-2">
        <div class="col-12 py-3 text-center">
            <h2>
                Sponsorships
                <i class="fa-solid fa-star"></i>
            </h2>
        </div>
    </div>

    <div class="container  p-lg-0">
        <div class="row mt-5 mt-md-0">
            {{-- le sponsorizzazioni disponibili --}}
            <div class="col-12 d-flex justify-content-center">

                @foreach ($sponsors->reverse() as $sponsor)
                    <div class=" me-5 rounded-5 shadow hvr" style="width: 18rem;">
                        <div class="text-center rounded-5 py-5 {{ $sponsor->id == 3 ? 'bg-warning' : 'bg-grey' }}">
                            <h5 class="">{{ explode(' ', $sponsor->title)[1] }}</h5>
                            <h1>&euro; {{ $sponsor->price }}</h1>
                        </div>
                        <div class="card-body px-2 my-4 d-flex flex-column align-items-center">
                            <div class="mb-3">
                                <i class="fa-regular fa-clock"></i>
                                <h5 class="d-inline">Durata {{ $sponsor->duration }}h</h5>
                            </div>
                            <p class="text-center" style="height: 130px;">{{ $sponsor->description }}</p>
                        </div>
                        <div class="d-flex justify-content-center mb-5">
                            <a href="{{ route('admin.sponsors.show', [$sponsor->id, 'apartment_id' => $apartment_id]) }}"
                                class="text-decoration-none btn-sponsor text-uppercase px-3 py-2 {{ $sponsor->id == 3 ? 'bg-warning' : 'border border-2 pay-hover' }}">Acquista</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
