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
            <canvas id="combinedChart" style="height: 400px;"></canvas>
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