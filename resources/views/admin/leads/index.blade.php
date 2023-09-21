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
                            <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                


                <div>
                    @foreach($leads as $lead)
                    <ul>
                        <li>
                            {{$lead->name}}
                        </li>
                        <li>
                            {{$lead->email}}
                        </li>
                        <li>
                            {{$lead->apartment_id}}
                        </li>
                    </ul>
                    
                    @endforeach
                </div>
@endsection
