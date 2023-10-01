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
            <canvas id="myChart" style="height: 400px; width: 100px;"></canvas> <!--imposta le dimensioni al solito modo, non sono riuscito bene a capire come ridurre la width--> 
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ctx = document.getElementById('myChart').getContext('2d');
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthsYears) !!}, //anni sull'asse x? Forse meglio mesi
                    datasets: [
                        {
                            label: 'Numero di visitatori',
                            data: {!! json_encode($monthlyViews->values()) !!}, //visitatori per anno? Mesi
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Numero di messaggi',
                            data: {!! json_encode($apartmentMessages->pluck('message_count')) !!}, // messaggi per anno?
                            borderColor: 'rgba(54, 162, 235, 1)', 
                            borderWidth: 2, 
                            fill: false 
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false, //parametri per le dimensioni e la responsività
                    responsive: true, //questo pure come sopra
                    scales: {
                        y: {
                            beginAtZero: true, //questo non serve per la responsività eh, ocio 
                        }
                    }
                }
            });
        });
    </script>
</div>
@endsection