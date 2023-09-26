@extends('layouts.admin')

@section('content')
    <div class="mx-5 container-fluid">
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
                    <h2>MESSAGGI RICEVUTI <span><i class="fa-solid text-primary fa-message fa-shake fa-xl"></i></span></h2>
                    <div class="button-container">
                        {{-- <a href="{{ route('admin.apartments.show', $apartment->id) }}" class="btn btn-bg btn-outline-success">Torna all'
                            appartamento
                            <i class="fa-solid fa-plus"></i></a> --}}
                    </div>
                </div>
                


                <div class="col-12 flex-wrap d-flex ">
                    @foreach($leads as $lead )
                    
                     <div class="col-3 border-message m-3 bg-light">
                        <p class="p-3 border-b"><strong>MITTENTE</strong>: {{$lead->name}}</p>
                        <p class="p-3 mb-0"><strong>email:</strong> {{$lead->email}}</p>
                        <p class="p-3 mb-0"><strong>contenuto del messaggio:</strong></p>
                        
                        
                        
                     </div>
                    @endforeach
                </div>
@endsection
