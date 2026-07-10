@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url('/kategori-items') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ url('/kategori-items/'.$kategori->id.'/pdf') }}" class="btn btn-success">Print / Download PDF</a>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">Detail Kategori</div>
                <div class="card-body">
                    <p><strong>Kode Kategori :</strong> {{ $kategori->kode }}</p>
                    <p><strong>Nama Kategori :</strong> {{ $kategori->nama }}</p>
                    
                    <hr>
                    <h5 class="mb-3">Daftar Item dalam Kategori Ini:</h5>
                    
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori->masterItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->supplier }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                            @if($kategori->masterItems->isEmpty())
                            <tr>
                                <td colspan="5" class="text-muted">Belum ada item untuk kategori ini.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection