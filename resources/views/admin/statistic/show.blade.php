@extends('layouts.admin')

@section('content')
<div class="row row-cols-1 mb-2 my-4 mx-2">
    <div class="col py-3">
        <h1>
            <span class="icon-section me-2">
                <i class="fa-solid fa-chart-line"></i>
            </span>
            Grafiche e Statistiche del tuo appartamento
        </h1>
    </div>
</div>

<div class="conteiner">
    <div class="row">
        <div class="col">
            <canvas id="combinedChart" style="height: 400px;"></canvas>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>
                Benvenuto nella pagina delle statistiche del tuo appartamento {{ $apartment->title }}, adesso puoi visualizzare l'andamento delle visite e dei tuoi messaggi per singolo appartamento mese per mese ed individuare i periodi di maggiore convenienza per attivare delle   
                    <a href="{{ route('admin.sponsors.index') }}"
                        class="list-group-item list-group-item-action py-2 ripple {{ Route::currentRouteName() === 'admin.sponsors.index' ? 'selected' : '' }} select">
                        <div class="text-container d-flex align-items-center">
                            <h4 class="ms-3">Sponsor</h4>
                        </div>
                    </a>
            </h2>
        </div>
        <div class="col">
            <a href="{{ route('admin.statistic.index') }}" class="back">
                Torna indietro
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ctx = document.getElementById('combinedChart').getContext('2d');
        let combinedChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthsYears) !!},
                datasets: [
                    {
                        label: 'Numero di visitatori',
                        data: {!! json_encode($monthlyViews->values()->toArray()) !!},
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        yAxisID: 'visitorY',
                    },
                    {
                        label: 'Numero di messaggi',
                        data: {!! json_encode($monthlyMessages->values()->toArray()) !!},
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        yAxisID: 'messageY',
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    'visitorY': {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                    },
                    'messageY': {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                    }
                }
            }
        });
    });
</script>
@endsection