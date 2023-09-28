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
            <div class="mt-5 " >
                <div class="d-flex  justify-content-center me-5 mb-3 p-2">
                    <h2>MESSAGGI RICEVUTI <span><i class="fa-solid text-primary fa-message fa-shake fa-xl"></i></span></h2>
                    
                </div>
                
                


                <div class="col-12 flex-wrap d-flex justify-content-center">
                    @foreach($leads as $lead )
                    
                     <div class="col-3 border-message m-3 bg-light">
                        <p class="p-3 border-b"><strong>MITTENTE</strong>: {{$lead->name}}</p>
                        <p class="p-3 mb-0"><strong>Email:</strong> {{$lead->email}}</p>
                        <p class="p-3 mb-0"><strong>Contenuto del messaggio:</strong></p>
                        <div class="container-content ff border-message m-3 mt-0 p-2">
                            <p>{{$lead->content}}</p>
                        </div>
                        <p class="ps-3">{{$newDate}}</p>
                        
                        
                     </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center pt-3">
        <a href="{{ route('admin.apartments.show', $lead->apartment_id) }}"
            class="btn btn-sm bg-primary text-light mx-1 rounded-5 btn-show">
            <i class="fa-solid fa-backward"></i> Torna all'appartamento</a>
    </div>             
@endsection
