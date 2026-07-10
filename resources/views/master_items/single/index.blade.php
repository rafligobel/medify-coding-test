@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ url('master-items') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Item</a>
                <div class="card">
                    <div class="card-header">Detail Master Item: {{ $data->nama }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Kode Barang</th>
                                <td>{{ $data->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $data->kategoris->pluck('nama')->implode(', ') ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>{{ $data->jenis }}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Laba</th>
                                <td>{{ $data->laba }}%</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $data->supplier }}</td>
                            </tr>
                            <tr>
                                <th>Foto Item</th>
                                <td>
                                    @if ($data->foto)
                                        <img src="{{ asset($data->foto) }}" alt="Foto" class="img-fluid rounded"
                                            style="max-height: 250px;">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="mt-3">
                            <a href="{{ url('master-items/form/edit/' . $data->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ url('master-items/delete/' . $data->id) }}" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
