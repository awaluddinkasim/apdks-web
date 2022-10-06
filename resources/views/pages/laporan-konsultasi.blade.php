@extends('layout.app')

@section('title', 'Laporan Konsultasi')

@section('content')
    @if ($daftarKonsultasi->count())
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <button type="button" class="btn btn-primary btn-sm" onclick="document.location.href = '{{ route('laporan-konsultasi.export') }}'">
                        Export PDF
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Tingkat Probabilitas</th>
                                <th>Jenis Kanker</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarKonsultasi as $konsultasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $konsultasi->user->nama }}</td>
                                    <td>{{ Str::ucfirst($konsultasi->resiko) }}</td>
                                    <td>
                                        {{ $konsultasi->id_kanker_serviks ? 'Kanker Serviks Stadium ' . $konsultasi->kanker->stadium : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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


@push('styles')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                sort: false
            });
        });
    </script>
@endpush
