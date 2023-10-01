@extends('layouts.admin')

@section('content')
<div class="row row-cols-1 mb-2 my-4 mx-2">
    <div class="col py-3">
        <h1>
            <span class="icon-section me-2">
                <i class="fa-solid fa-chart-line"></i>
            </span>
            GRAFICHINI STASTISTICHINI POLLANCHE PANINI E PANELLE
        </h1>
    </div>

    <div class="col">
        <a href="{{ route('admin.statistic.index') }}" class="back">
            Torna indietro
            <i class="fa-solid fa-rotate-left"></i>
        </a>
    </div>
</div>

<div class="conteiner">
    <div class="row">
        <div class="col">
            <canvas id="visitorChart" style="height: 400px; width: 100px;"></canvas>
        </div>
        <div class="col">
            <canvas id="messageChart" style="height: 400px; width: 100px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let visitorCtx = document.getElementById('visitorChart').getContext('2d');
        let visitorChart = new Chart(visitorCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_reverse($monthsYears)) !!},
                datasets: [{
                    label: 'Numero di visitatori',
                    data: {!! json_encode(array_reverse($monthlyViews->values()->toArray())) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        let messageCtx = document.getElementById('messageChart').getContext('2d');
        let messageChart = new Chart(messageCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_reverse($monthsYearsMessages)) !!}, // Inverti l'array
                datasets: [{
                    label: 'Numero di messaggi',
                    data: {!! json_encode(array_reverse($monthlyMessages->values()->toArray())) !!}, // Inverti l'array
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    });
</script>
@endsection