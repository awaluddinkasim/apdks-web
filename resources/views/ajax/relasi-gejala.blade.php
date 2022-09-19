@forelse ($daftarRelasi as $relasi)
    <tr>
        <td>{{ $relasi->gejala->keterangan }}</td>
        <td class="text-center">
            <form action="{{ route('master-data.delete', 'relasi') }}" class="d-inline" method="POST">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="{{ $relasi->id }}">
                <button class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="2" class="text-center">Tidak ada data</td>
    </tr>
@endforelse
