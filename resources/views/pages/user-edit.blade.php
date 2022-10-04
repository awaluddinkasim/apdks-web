@extends('layout.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="row">
        <div class="col-md-7 text-center">
            <img src="{{ asset('assets/img/user.svg') }}" alt="" class="w-75">
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.update') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" value="{{ $user->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $user->tgl_lahir }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary float-right" type="submit">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
