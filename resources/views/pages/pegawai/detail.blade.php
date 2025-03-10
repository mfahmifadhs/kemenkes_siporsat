@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid col-md-6">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">{{ $data->nama_pegawai }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('pegawai') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>

            </div>
        </div>
    </div>
</div>

<!-- ChoseUs Section Begin -->
<section class="content">
    <div class="container-fluid col-md-6">
        <div class="card border border-dark">
            <div class="card-header border-bottom border-dark">
                <h3 class="text-center p-2">
                    <i class="fa fa-user-circle fa-4x"></i>
                </h3>
            </div>
            <div class="card-body border-bottom border-dark">
                <label class="text-secondary text-sm"><i>Informasi Pegawai</i></label>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <h6 class="mb-0 text-sm">Unit Kerja</h6>
                        <label class="text-sm text-capitalize mb-0">{{ $data->uker->unit_kerja }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Nama Pegawai</h6>
                        <label class="text-sm">{{ $data->nama_pegawai }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">NIP</h6>
                        <label class="text-sm">{{ $data->nip }}</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <h6 class="mb-0 text-sm">Jabatan</h6>
                        <label class="text-sm">{{ $data->jabatan->jabatan }} {{ $data->tim_kerja }}</label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('pegawai.edit', $data->id_pegawai) }}" class="btn btn-warning bg-main btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
