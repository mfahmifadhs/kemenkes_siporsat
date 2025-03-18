@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-9">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit AADB</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                            Edit AADB
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('aadb.update', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-5">
                                        @if ($data->foto_barang)
                                        <img id="modal-foto" src="{{ asset('dist/img/foto_aadb/'. $data->foto_barang) }}" alt="Foto Barang" class="img-fluid">
                                        @else
                                        <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" alt="Foto Barang" class="img-fluid">
                                        @endif

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
                                                    <option value="{{ $row->id_unit_kerja }}" <?= $row->id_unit_kerja == $data->uker_id ? 'selected' : ''; ?>>
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
                                                    <option value="{{ $row->id_kategori }}" <?= $row->id_kategori == $data->kategori_id ? 'selected' : ''; ?>>
                                                        {{ $row->kode }} - {{ $row->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">NUP</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nup" value="{{ $data->nup }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Jenis AADB</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="jenis" class="form-control" required>
                                                    <option value="">-- Pilih Jenis AADB --</option>
                                                    <option value="bmn" <?= $data->jenis_aadb == 'bmn' ? 'selected' : ''; ?>>BMN</option>
                                                    <option value="sewa" <?= $data->jenis_aadb == 'sewa' ? 'selected' : ''; ?>>Sewa</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Merk / Tipe</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="merktipe" value="{{ $data->merk_tipe }}" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">No. Polisi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nopolisi" value="{{ $data->no_polisi }}" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">No. BPKP</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="nobpkp" value="{{ $data->no_bpkp }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Status Penggunaan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kualifikasi" class="form-control" required>
                                                    <option value="">-- Pilih Status Penggunaan --</option>
                                                    <option value="fungsional" <?= $data->kualifikasi == 'fungsional' ? 'selected' : ''; ?>>Fungsional</option>
                                                    <option value="jabatan" <?= $data->kualifikasi == 'jabatan' ? 'selected' : ''; ?>>Jabatan</option>
                                                    <option value="operasional" <?= $data->kualifikasi == 'operasional' ? 'selected' : ''; ?>>Opersional</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Deskripsi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="deskripsi" value="{{ $data->deskripsi }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Tanggal Perolehan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="date" class="form-control" name="tanggal" value="{{ Carbon\Carbon::parse($data->tanggal_perolehan)->format('Y-m-d') }}" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Nilai Perolehan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control number" name="nilai" value="{{ number_format($data->nilai_perolehan, 0, ',', '.') }}" required>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Kondisi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kondisi" class="form-control" required>
                                                    <option value="">-- Pilih Kondisi --</option>
                                                    @foreach ($kondisi as $row)
                                                    <option value="{{ $row->id_kondisi }}" <?= $row->id_kondisi == $data->kondisi_id ? 'selected' : ''; ?>>
                                                        {{ $row->nama_kondisi }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Keterangan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" class="form-control" name="keterangan" value="{{ $data->keterangan }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Status</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="status" class="form-control">
                                                    <option value="true" <?= $data->status == 'true' ? 'selected' : ''; ?>>Tersedia</option>
                                                    <option value="false" <?= $data->status == 'false' ? 'selected' : ''; ?>>Tidak Tersedia</option>
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
