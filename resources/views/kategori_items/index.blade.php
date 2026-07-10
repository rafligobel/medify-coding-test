@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ url('/kategori-items/create') }}" class="btn btn-secondary mb-2">+ Kategori Baru</a>

                <div class="card">
                    <div class="card-header">Daftar Kategori Items</div>
                    <div class="card-body">
                        {{-- Filter Kategori --}}
                        <form method="GET" action="{{ url('/kategori-items') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="kode" class="form-control" placeholder="Cari Kode"
                                        value="{{ request('kode') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Cari Nama Kategori" value="{{ request('nama') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategoris as $index => $kat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $kat->kode }}</td>
                                        <td>{{ $kat->nama }}</td>
                                        <td>
                                            <a href="{{ url('/kategori-items/view/' . $kat->id) }}"
                                                class="btn btn-sm btn-info text-white">View</a>
                                            <a href="{{ url('/kategori-items/edit/' . $kat->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ url('/kategori-items/delete/' . $kat->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus kategori ini?')">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($kategoris->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-muted">Data Kategori Tidak Ditemukan</td>
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
