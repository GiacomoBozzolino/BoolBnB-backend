@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="pt-4">
            Benvenuto! Siamo felici di averti qui con noi {{ Auth::user()->name }}!

            {{-- PAGINA BYPASSATA TRAMITE WEB.PHP --}}
        </h1>

    </div>
@endsection
