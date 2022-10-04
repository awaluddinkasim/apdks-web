@extends('layout.app')

@section('title', 'Laporan Konsultasi')

@section('content')
    @if ($daftarKonsultasi->count())
        <div class="card mb-3">
            <div class="card-body"></div>
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
