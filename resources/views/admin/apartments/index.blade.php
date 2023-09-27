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
                <div class="d-flex justify-content-between justify-content-center me-5 mb-3 p-2">
                    <h2>Questi sono i tuoi appartamenti</h2>
                    <div class="button-container">
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-bg btn-outline-success">Aggiungi
                            appartamento
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="border border-light rounded-3 d-flex flex-wrap justify-content-start">
                    {{-- CARDS --}}
                    @foreach ($apartments as $apartment)
                        <div class="m-4 d-flex border rounded-5 p-4" style="width: 40rem; ">
                            {{-- imagine --}}
                            <div class="">
                                <img src="{{ asset('storage/' . $apartment->cover_img) }}"
                                    class="card-img-top ratio ratio-4x3 rounded-5" alt="{{ $apartment->title }}">
                            </div>
                            {{-- CARD CONTETN --}}
                            <div class="card-container ms-4">
                                {{-- text card --}}
                                <div class="card-body">
                                    <h4 class="card-title text-center ">{{ $apartment->title }}</h4>
                                    <div class="description-card overflow-auto mt-2">
                                        <p class="card-text
                                        py-2 text-start">
                                            {{ $apartment->description }} Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. Accusantium eos quae, repudiandae illum eum voluptatum possimus, ipsam
                                            excepturi libero id quia praesentium nostrum. Enim eveniet voluptatem neque
                                            dicta molestias nesciunt?</p>
                                    </div>
                                </div>
                                {{-- Visibilita --}}
                                <div class="visibility-container text-center mt-3">
                                    @if ($apartment->visibility === 1)
                                        <strong>Il tuo anuncio e <span class="badge text-bg-success">On-Line</span></strong>
                                    @else
                                        <strong>Il tuo annuncio e <span
                                                class="badge text-bg-danger">Off-Line</span></strong>
                                    @endif
                                </div>
                                {{-- servizi --}}
                                <ul class="list-group list-group-flush text-center mt-2">
                                    <li class="list-group-item">

                                        @if (count($apartment->services) > 0)
                                            @foreach ($apartment->services as $item)
                                                <?php echo $item->icon; ?>
                                            @endforeach
                                        @else
                                            <strong>Non ci sono servizi inseriti</strong>
                                        @endif
                                    </li>
                                </ul>
                                {{-- tasti di navigazione  --}}
                                <div class="my-2 d-flex align-items-center justify-content-center">
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
                                        <form class="apartment-delete-button d-inline-block mx-1 btn-delete rounded-5"
                                            data-apartment-title="{{ $apartment->title }}"
                                            action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.modal_apartment_delete')
    {{-- @include('admin.partials.modal_delete') --}}
@endsection
