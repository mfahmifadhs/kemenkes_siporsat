@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-9">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Tambah AADB</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-9">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary border border-dark">
                    <div class="card-header border-bottom border-dark">
                        <label class="card-title">
                            Tambah AADB
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('aadb.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-5">
                                        <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" alt="Foto Barang" class="img-fluid">

                                        <div class="btn btn-warning btn-block btn-sm mt-1 btn-file border-dark">
                                            <i class="fas fa-paperclip"></i> Upload Foto
                                            <input type="file" name="foto" class="previewImg" data-preview="modal-foto" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <label class="col-md-12 text-secondary">Informasi AADB</label>


                                            <div class="col-md-3 col-form-label my-1">Unit Kerja</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="uker" class="form-control" required>
                                                    <option value="">-- Pilih Unit Kerja --</option>
                                                    @foreach ($uker as $row)
                                                    <option value="{{ $row->id_unit_kerja }}">
                                                        {{ $row->unit_kerja }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Kategori</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kategori" class="form-control" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    @foreach ($kategori as $row)
                                                    <option value="{{ $row->id_kategori }}">
                                                        {{ $row->kode }} - {{ $row->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">NUP</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nup">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Jenis AADB</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="jenis" class="form-control" required>
                                                    <option value="">-- Pilih Jenis AADB --</option>
                                                    <option value="bmn">BMN</option>
                                                    <option value="sewa">Sewa</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Merk / Tipe</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="merktipe" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">No. Polisi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nopolisi" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">No. BPKP</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nobpkp">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Status Penggunaan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kualifikasi" class="form-control" required>
                                                    <option value="">-- Pilih Status Penggunaan --</option>
                                                    <option value="fungsional">Fungsional</option>
                                                    <option value="jabatan">Jabatan</option>
                                                    <option value="operasional">Opersional</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Deskripsi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="deskripsi">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Tanggal Perolehan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="date" class="form-control" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Nilai Perolehan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control number" name="nilai" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Kondisi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kondisi" class="form-control" required>
                                                    <option value="">-- Pilih Kondisi --</option>
                                                    @foreach ($kondisi as $row)
                                                    <option value="{{ $row->id_kondisi }}">{{ $row->nama_kondisi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Keterangan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="keterangan">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Status</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="status" class="form-control">
                                                    <option value="true">Tersedia</option>
                                                    <option value="false">Tidak Tersedia</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top border-dark text-right">
                                <button type="button" class="btn btn-primary font-weight-bold" onclick="confirmSubmit(event, 'form')">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
