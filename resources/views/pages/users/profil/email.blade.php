@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-5">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">Verifikasi Email</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Email</li>
                </ol>

            </div>
            <div class="col-sm-6 text-right">
                <!-- <a href="{{ url('unit-kerja/ukt/usulan/pekerjaan/baru') }}" class="btn btn-primary btn-md font-weight-bold mt-3">
                    <i class="fas fa-plus-square"></i> PENGAJUAN
                </a> -->
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-5">
        <div class="card border border-dark">
            <div class="card-header">
                <label for="">Verifikasi Email</label>
            </div>
            <form id="form-submit" action="{{ route('email.update') }}" method="GET">
                @csrf
                <div class="card-body">
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Masukkan Email" required>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-success btn-sm border border-dark" onclick="confirmSubmit(event, 'form-submit')">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="#" class="btn btn-danger btn-sm border border-dark" onclick="confirmLink(event, `{{ route('email.delete', $user->id) }}`)">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
