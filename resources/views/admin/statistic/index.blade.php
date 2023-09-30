@extends('layouts.admin')

@section('content')
<div class="row row-cols-1 mb-2 my-4 mx-2">
        <div class="col py-3">
            <h1>
                <span class="icon-section me-2">
                    <i class="fa-solid fa-sack-dollar fa-sm"></i>
                </span>
                Le statistiche dei miei appartamenti:
            </h1>
        </div>

        <div class="col">
            <a href="{{ route('admin.sponsors.index') }}" class="back">
                Torna indietro
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </div>
@endsection