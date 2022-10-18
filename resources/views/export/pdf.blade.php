<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Diagnosa</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="text-center">
        <h4>Laporan Hasil Diagnosa</h4>
    </div>
    <table class="table table-bordered" width="100%" cellspacing="0">
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
</body>
</html>
