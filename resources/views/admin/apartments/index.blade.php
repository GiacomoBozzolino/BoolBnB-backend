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
                <div class="col-12 d-flex justify-content-between justify-content-center me-5 mb-3 p-2">
                    <h2>Questi sono i tuoi appartamenti</h2>
                    <div class="button-container">
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-bg btn-outline-success">Aggiungi
                            appartamento
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class=" col-12 rounded-4 border border-2 p-4 shadow overflow-auto" style="height: 900px">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Visibile</th>
                                <th>Titolo</th>
                                <th>Indirizzo</th>
                                <th>Servizi</th>
                                <th>Sposorizzazioni</th>
                                <th>Termine</th>
                                <th>Strumenti</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        @foreach ($apartment->sponsors as $sponsor)
                                            <i class="fas fa-star"></i> <span>{{ $sponsor->title }}</span> <i
                                                class="fas fa-star"></i>
                                        @endforeach
                                    </td>
                                    {{-- Termine sposorizzazione --}}
                                    <td>
                                        @foreach ($apartment->sponsors as $sponsor)
                                            <span>Fino al {{ $sponsor->pivot->end_at }}</span>
                                        @endforeach
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
