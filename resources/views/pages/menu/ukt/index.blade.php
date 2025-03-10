@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Kerumahtanggaan</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <form action="" method="GET">
                            @csrf
                            <button class="border border-transparent bg-transparent btn-block text-left">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0 <small>usulan</small></h3>
                                        <p>Total Usulan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-2 col-12">
                        <form action="" method="GET">
                            @csrf
                            <button class="border border-transparent bg-transparent btn-block text-left">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0 <small>usulan</small></h3>
                                        <p>Persetujuan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-2 col-12">
                        <form action="" method="GET">
                            @csrf
                            <button class="border border-transparent bg-transparent btn-block text-left">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0 <small>usulan</small></h3>
                                        <p>Proses</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-circle-exclamation"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-2 col-12">
                        <form action="" method="GET">
                            @csrf
                            <button class="border border-transparent bg-transparent btn-block text-left">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0 <small>usulan</small></h3>
                                        <p>Selesai</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-circle-check"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-2 col-12">
                        <form action="" method="GET">
                            @csrf
                            <button class="border border-transparent bg-transparent btn-block text-left">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0 <small>usulan</small></h3>
                                        <p>Ditolak</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-circle-xmark"></i>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-md-6">
                        <a href="{{ route('usulan', 'ukt') }}" class="btn btn-default border-secondary p-4 btn-block">
                            <i class="fas fa-copy fa-3x"></i>
                            <h6 class="mt-3 font-weight-bolder">Daftar Usulan</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
