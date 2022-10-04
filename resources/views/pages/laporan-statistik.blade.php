@extends('layout.app')

@section('title', 'Laporan Statistik')

@section('content')
    @if ($konsultasi)
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="card">
                    <div class="card-body">
                        <canvas id="pie-chart" width="800" height="450"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <canvas id="bar-chart" width="800" height="950"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card mb-3">
            <div class="card-body text-center">
                <img src="{{ asset('assets/img/kosong.svg') }}" alt="" style="max-width: 80%; width: 400px">
                <h4>Belum ada data konsultasi ditemukan</h4>
            </div>
        </div>
    @endif
@endsection

@php
$dibawah30 = $users->filter(function ($item) {
    return $item->umur < 30;
});
$diatas30 = $users->filter(function ($item) {
    return $item->umur >= 30;
});
@endphp
@if ($konsultasi)
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            new Chart(document.getElementById("pie-chart"), {
                type: 'pie',
                data: {
                    labels: [
                        @foreach ($daftarGejala as $gejala)
                            '{{ $gejala->keterangan }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: [
                            @foreach ($daftarGejala as $gejala)
                                '#{{ dechex(rand(0x000000, 0xffffff)) }}',
                            @endforeach
                        ],
                        data: [
                            @foreach ($daftarGejala as $gejala)
                                '{{ $gejala->keluhan->count() }}',
                            @endforeach
                        ]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Grafik keluhan berdasarkan gejala'
                    }
                }
            });

            new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                    labels: ["Dibawah 30 Tahun", "Diatas 30 Tahun"],
                    datasets: [{
                        label: "Data Pengguna berdasarkan umur",
                        backgroundColor: ["#3e95cd", "#8e5ea2"],
                        data: [
                            '{{ $dibawah30->count() }}',
                            '{{ $diatas30->count() }}',
                        ]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Pengguna berdasarkan umur'
                    }
                }
            });
        </script>
    @endpush
@endif
