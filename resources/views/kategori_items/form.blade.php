@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ url('/kategori-items') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Kategori</a>
            
            <div class="card">
                <div class="card-header">{{ isset($kategori) ? 'Edit Kategori' : 'Buat Kategori Baru' }}</div>
                
                <div class="card-body">
                    <form method="POST" action="{{ isset($kategori) ? url('/kategori-items/update/'.$kategori->id) : url('/kategori-items/store') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Kode Kategori</label>
                            <input type="text" name="kode" class="form-control" value="{{ $kategori->kode ?? '' }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama" class="form-control" value="{{ $kategori->nama ?? '' }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection