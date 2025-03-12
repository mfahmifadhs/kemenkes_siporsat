@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Detail Barang</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('atk-barang') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-8">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Detail Barang
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body border border-dark">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="text-secondary">Informasi Barang</label>
                                    @if ($data->foto_barang)
                                    <img id="modal-foto" src="{{ asset('dist/img/foto_atk/'. $data->foto_barang) }}" alt="Foto Barang" class="img-fluid">
                                    @else
                                    <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/512/679/679821.png" alt="Foto Barang" class="img-fluid">
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="row">

                                        <div class="col-md-3 col-form-label my-1">ID</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="id_atk" value="{{ $data->id_atk }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Kategori</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="kategori" value="{{ $data->kategori->nama_kategori }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Barang</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="nama_barang" value="{{ $data->nama_barang }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Deskripsi</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="deskripsi" value="{{ $data->deskripsi }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Harga</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="harga" value="{{ $data->harga }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Satuan</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="satuan" value="{{ $data->satuan->nama_satuan }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Keterangan</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control number" name="keterangan" value="{{ $data->keterangan }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Status</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control number" name="status" value="{{ $data->status == 'true' ? 'Tersedia' : 'Tidak Tersedia' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
