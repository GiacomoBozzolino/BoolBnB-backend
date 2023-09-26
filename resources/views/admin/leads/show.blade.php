@extends('layouts.admin')

@section('content')
    <div class="px-2 wall-paper">
        <div class="row justify-content-center ">
            <div class="col-12 d-flex justify-content-center ">
                 <h1 class=" p-3">MESSAGGIO RICEVUTO <span><i class="fa-solid fa-message text-primary fa-shake fa-xl"></i></span></h1>
            </div>
           
            <div class="col-8  border-message m-3 bg-light ">
                <p class="p-3 border-b"><strong>MITTENTE</strong>: {{$lead->name}}</p>
                <p class="p-3 mb-0"><strong>Email:</strong> {{$lead->email}}</p>
                <p class="p-3 mb-0"><strong>Contenuto del messaggio:</strong></p>
                <div class="container-content ff border-message m-3 mt-0 p-2">
                    <p>{{$lead->content}}</p>
                </div>
                
                
            </div>
            
        </div>
       
    </div>
@endsection
