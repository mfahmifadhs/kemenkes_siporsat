@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-9">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Detail AADB</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-9">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Detail AADB
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body border border-dark" style="overflow-y: auto; max-height: 70vh;">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <label class="text-secondary">Informasi AADB</label>
                                    @if ($data->foto_barang)
                                    <img id="modal-foto" src="{{ asset('dist/img/foto_aadb/'. $data->foto_barang) }}" alt="Foto Barang" class="img-fluid">
                                    @else
                                    <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" alt="Foto Barang" class="img-fluid">
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="row">

                                        <div class="col-md-3 col-form-label my-1">ID</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="id_aadb" value="{{ $data->id_aadb }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Unit Kerja</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="uker" value="{{ $data->uker->unit_kerja }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Kode BMN</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="kode" value="{{ $data->kategori->kode }}.{{ $data->nup }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Kategori</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="kategori" value="{{ $data->kategori->nama_kategori }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Merk/Tipe</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="merk_tipe" value="{{ $data->merk_tipe }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">No. Polisi</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="no_polisi" value="{{ $data->no_polisi }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">No. BPKPK</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="no_bpkp" value="{{ $data->no_bpkp }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Status Penggunaan</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="kualifikasi" value="{{ $data->kualifikasi }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Deskripsi</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="deskripsi" value="{{ $data->deskripsi }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Tanggal Perolehan</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="tanggal" value="{{ $data->tanggal_perolehan }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Harga</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control" name="harga" value="{{ number_format($data->nilai_perolehan, 0, ',', '.') }}" readonly>
                                        </div>

                                        <div class="col-md-3 col-form-label my-1">Kondisi</div>
                                        <div class="col-md-1 col-form-label my-1">:</div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" class="form-control number" name="kondisi" value="{{ $data->kondisi->nama_kondisi }}" readonly>
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
