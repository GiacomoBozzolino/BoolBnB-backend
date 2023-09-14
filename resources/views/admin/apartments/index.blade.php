@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mt-5">
                <div class="d-flex justify-content-between justify-content-center me-5 mb-3 p-2">
                    <h2>Questi sono i tuoi apartamenti</h2>
                    <div class="button-container">
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-bg btn-outline-success">Aggiungi
                            apartamento
                            <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="border border-primary-subtle rounded-3 p-5 bg-light">
                    <table class="">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Rooms</th>
                                <th scope="col">Bedrooms</th>
                                <th scope="col">Bathrooms</th>
                                <th scope="col">Strumenti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr>
                                    <td>{{ $apartment->title }}</td>
                                    <td>{{ $apartment->slug }}</td>
                                    <td>{{ $apartment->n_rooms }}</td>
                                    <td>{{ $apartment->n_beds }}</td>
                                    <td>{{ $apartment->n_bathrooms }}</td>
                                    <td class="d-flex">
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
                                            <form class="project-delete-button d-inline-block mx-1 btn-delete rounded-5"
                                                data-project-title="{{ $apartment->name }}"
                                                action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
