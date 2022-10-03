@extends('layout.app')

@section('title', 'Master Data Relasi')

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

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#penyakitModal">
                    Tambah
                </button>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="jenisPenyakit">Nama Penyakit</label>
                        <select name="jenis-penyakit" id="jenisPenyakit">
                            <option value="" selected hidden>Pilih</option>
                            @foreach ($daftarPenyakit as $penyakit)
                                <option value="{{ $penyakit->id }}">{{ $penyakit->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Gejala</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="gejalaTable">
                                <tr>
                                    <td colspan="2" class="text-center">Loading...</td>
                                </tr>
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
                    <h5 class="modal-title" id="penyakitModalLabel">Input Relasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('master-data.store', 'relasi') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="penyakit">Nama Penyakit</label>
                            <select name="penyakit" id="penyakit">
                                <option value="" selected hidden>Pilih</option>
                                @foreach ($daftarPenyakit as $penyakit)
                                    <option value="{{ $penyakit->id }}">{{ $penyakit->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gejala">Gejala</label>
                            <select name="gejala" id="gejala">
                                <option value="" selected hidden>Pilih</option>
                                @foreach ($daftarGejala as $gejala)
                                    <option value="{{ $gejala->id }}">{{ $gejala->keterangan }}</option>
                                @endforeach
                            </select>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/selectize/selectize.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/selectize/selectize.min.js') }}"></script>
    <script>
        $("#jenisPenyakit").selectize({
            onInitialize: function() {
                this.clear()
                $.ajax({
                    url: '/relasi/gejala?id=',
                    type: 'GET',
                    success: function (result) {
                        $('#gejalaTable').html(result);
                    }
                })
            },
            onChange: function(value) {
                $.ajax({
                    url: '/relasi/gejala?id='+value,
                    type: 'GET',
                    success: function (result) {
                        $('#gejalaTable').html(result);
                    }
                })
            }
        });

        $("select").selectize();
    </script>
@endpush
