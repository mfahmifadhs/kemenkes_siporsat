@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-7 mt-5">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Usulan AADB</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Usulan</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-7 col-12">
        <div class="row">
            <div class="col-md-12 col-12 form-group">
                <a href="{{ route('usulan.create', 'servis') }}" class="btn btn-default border border-dark p-4 w-100 bg-servis">
                    <div class="row">
                        <div class="col-md-3 my-auto">
                            <i class="fas fa-car-on fa-4x"></i>
                        </div>
                        <div class="col-md-9 text-justify">
                            <h6 class="font-weight-bold">Usulan Pemeliharaan</h6>
                            <span class="small">
                                Usulan Pemeliharaan Alat Angkutan Darat Bermotor
                            </span>
                        </div>
                        <div class="col-md-12 mt-3 text-right">
                            <span class="border border-white p-2 text-sm">Usulkan <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 col-12 form-group">
                <a href="{{ route('usulan.create', 'bbm') }}" class="btn btn-default border border-dark p-3 w-100 bg-bbm">
                    <div class="row">
                        <div class="col-md-3 my-auto">
                            <i class="fas fa-gas-pump fa-4x"></i>
                        </div>
                        <div class="col-md-9 text-justify">
                            <h6 class="font-weight-bold">Usulan BBM</h6>
                            <span class="small">
                                Usulan Permintaan Voucher BBM, dapat diusulan setiap tanggal 20 bulan berjalan.
                            </span>
                        </div>
                        <div class="col-md-12 mt-3 text-right">
                            <span class="border border-white p-2 text-sm">Usulkan <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
