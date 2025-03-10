@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid col-md-6">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">{{ $data->pegawai->nama_pegawai }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil Saya</li>
                </ol>

            </div>
        </div>
    </div>
</div>

<!-- ChoseUs Section Begin -->
<section class="content">
    <div class="container-fluid col-md-6">
        <div class="card border border-dark">
            <div class="card-body border-bottom border-dark">
                <div class="form-group border-bottom border-dark mb-4">
                    <label class="mb-0"><i class="fas fa-user-circle text-main"></i> Profil Saya,</label>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Unit Kerja</label>
                    <h6>{{ $data->pegawai->uker->unit_kerja }} | {{ $data->pegawai->uker->utama->unit_utama }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Nama Pegawai</label>
                    <h6>{{ $data->pegawai->nama_pegawai }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">NIP</label>
                    <h6>{{ $data->pegawai->nip }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Jabatan</label>
                    <h6>{{ $data->pegawai->jabatan->jabatan }} {{ $data->pegawai->tim_kerja }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Keterangan</label>
                    <h6>{{ $data->keterangan ?? '-' }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Username</label>
                    <h6>{{ $data->username ?? '-' }}</h6>
                </div>
                <div class="form-group border-bottom border-dark my-3">
                    <label class="mb-0">Email</label>
                    <h6>{{ $data->email ?? '-' }}</h6>
                </div>
                <div class="form-group my-2">
                    <label class="mb-0">Status</label>
                    <h6>
                        @if($data->status == 'true')
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </h6>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('profil.edit', $data->id) }}" class="btn btn-warning bg-main btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
