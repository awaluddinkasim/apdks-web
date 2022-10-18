@extends('layout.app')

@section('title', 'Data Dokter')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ Session::get('success') }}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ Session::get('failed') }}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dokter.update') }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row px-lg-4 mb-4 align-items-center">
                            <div class="col">
                                <img src="{{ $dokter ? asset('doctor/' . $dokter->foto) : asset('assets/img/profil-doctor.svg') }}"
                                    alt="Not found" class="foto">
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off"
                                value="{{ $dokter->nama ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                                value="{{ $dokter->email ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Kontak</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" autocomplete="off"
                                value="{{ $dokter->no_hp ?? '' }}" required>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary float-right" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7 text-center">
            <img src="{{ asset('assets/img/doctor.svg') }}" alt="" class="w-75">
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .foto {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
@endpush
