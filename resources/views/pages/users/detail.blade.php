@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid col-md-6">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">{{ $data->pegawai->nama_pegawai }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('users') }}"> Daftar</a></li>
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
                        <label class="text-sm text-capitalize mb-0">{{ $data->pegawai->uker->unit_kerja }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Role</h6>
                        <label class="text-sm">{{ $data->role->nama_role }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Akses</h6>
                        <label class="text-sm">{{ $data->akses->nama_akses ?? 'Tidak ada' }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Nama Pegawai</h6>
                        <label class="text-sm">{{ $data->pegawai->nama_pegawai }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">NIP</h6>
                        <label class="text-sm">{{ $data->pegawai->nip }}</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <h6 class="mb-0 text-sm">Jabatan</h6>
                        <label class="text-sm">{{ $data->pegawai->jabatan->jabatan }} {{ $data->pegawai->tim_kerja }}</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <h6 class="mb-0 text-sm">Keterangan</h6>
                        <label class="text-sm">{{ $data->keterangan }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Username</h6>
                        <label class="text-sm">{{ $data->username }}</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <h6 class="mb-0 text-sm">Password</h6>
                        <label class="text-sm">{{ $data->password_teks }}</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <h6 class="mb-0 text-sm">Status</h6>
                        <label class="text-sm">
                            @if($data->status == 'true')
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('users.edit', $data->id) }}" class="btn btn-warning bg-main btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
