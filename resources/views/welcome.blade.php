@extends('layouts.app')
@section('content')
    <div class="jumbotron-welcome-base">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {{-- IMAGE EFFECTS --}}
                    <div class="container-animation">
                        <div class="box">
                            <img
                                src="https://a0.muscache.com/im/pictures/74fe16d9-5712-4228-b5c6-165e9f3802a3.jpg?im_w=1200">
                        </div>
                        <div class="box">
                            <img
                                src="https://a0.muscache.com/im/pictures/03d1a59c-672d-4c10-80ec-3dce231fc643.jpg?im_w=1200">
                        </div>
                        <div class="box">
                            <img src="https://a0.muscache.com/im/pictures/40706270/81c0585d_original.jpg?im_w=1200">
                        </div>
                        <div class="box">
                            <img
                                src="https://a0.muscache.com/im/pictures/03d1a59c-672d-4c10-80ec-3dce231fc643.jpg?im_w=1200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- DESCRIPTION --}}
        <div class="jumbotron-welcome-partial">
            <div class="container py-5 welcome-style">
                <div class="row">
                    {{-- BIENVENIDOS PART --}}
                    <div class="col-12 p-5 ">
                        <h1 class="display-5 fw-bold">
                            Benvenuto su BoolBnb Dash
                        </h1>

                        <p class="col-md-8 fs-4">Benvenuto nel tuo portale personale, l'hub per gestire, inserire e
                            modificare i
                            tuoi
                            appartamenti. Qui troverai tutto ciò di cui hai bisogno per gestire al meglio le tue proprietà
                            immobiliari
                            in modo semplice ed efficiente.<br>
                            Scopri strumenti intuitivi e ottieni il controllo totale sulla gestione.

                        </p>
                        <a href="{{ url('admin/apartments') }}"
                            class="btn btn-primary btn-lg btn-color text-uppercase fw-semibold" type="button">Scopri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
