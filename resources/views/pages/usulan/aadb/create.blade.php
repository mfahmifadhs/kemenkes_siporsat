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
                <a href="" class="btn btn-default border border-dark p-5 w-100 bg-servis">
                    <i class="fas fa-car-on fa-3x"></i>
                    <h6 class="mt-3">Usulan Pemeliharaan</h6>
                </a>
            </div>
            <div class="col-md-12 col-12 form-group">
                <a href="" class="btn btn-default border border-dark p-3 w-100 bg-bbm">
                    <i class="fas fa-gas-pump fa-3x"></i>
                    <h6 class="my-3">Usulan BBM</h6>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
