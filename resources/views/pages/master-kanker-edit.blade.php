@extends('layout.app')

@section('title', 'Master Data Kanker')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('master-kanker.update') }}" method="post">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{ $kanker->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stadium">Stadium Kanker</label>
                            <input type="number" max="4" class="form-control" id="stadium" name="stadium" autocomplete="off"
                                disabled value="{{ $kanker->stadium }}">
                        </div>
                        <div class="form-group">
                            <label for="penyebab">Penyebab</label>
                            <textarea class="form-control" id="penyebab" rows="6" name="penyebab" required>{{ $kanker->penyebab }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" required>{{ $kanker->keterangan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="solusi">Solusi</label>
                            <textarea class="form-control" id="solusi" rows="3" name="solusi" required>{{ $kanker->solusi }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <button class="btn btn-primary float-right" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
