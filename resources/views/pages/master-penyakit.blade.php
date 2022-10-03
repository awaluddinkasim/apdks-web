@extends('layout.app')

@section('title', 'Master Data Penyakit')

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
            <strong>Berhasil!</strong> {{ Session::get('failed') }}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/med_res.svg') }}" alt="" class="w-75">
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#penyakitModal">
                            Tambah
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyakit</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarPenyakit as $penyakit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $penyakit->nama }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('master-data.delete', 'penyakit') }}" class="d-inline"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $penyakit->id }}">
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="penyakitModal" tabindex="-1" aria-labelledby="penyakitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyakitModalLabel">Input Penyakit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('master-data.store', 'penyakit') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Penyakit</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="penyebab">Penyebab</label>
                            <textarea class="form-control" id="penyebab" rows="3" name="penyebab" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="solusi">Solusi</label>
                            <textarea class="form-control" id="solusi" rows="3" name="solusi" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
