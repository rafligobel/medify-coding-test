@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-group mb-2 d-flex justify-content-between">
                    <a href="{{ url('master-items/form/new') }}" class="btn btn-secondary">+ Master Items Baru</a>
                    {{-- Tombol Export Excel --}}
                    <a href="{{ url('master-items/export-excel') }}" class="btn btn-success">Download Excel</a>
                </div>
                <div class="card">
                    <div class="card-header">Daftar Master Items</div>

                    <div class="card-body">
                        @include('master_items.index.filter')
                        <div class="table-responsive mt-3">
                            @include('master_items.index.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('master_items.index.js')
@endsection
