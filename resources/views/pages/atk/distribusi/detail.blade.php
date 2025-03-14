@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Detail Distribusi ATK</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('atk-distribusi') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>

            </div>
        </div>
    </div>
</div>

<!-- ChoseUs Section Begin -->
<section class="content">
    <div class="container-fluid col-md-8">
        <div class="card border border-dark">
            <div class="card-header border-bottom border-dark">
                <div class="row">
                    <div class="col-md-3 col-12 my-auto">
                        <h3 class="text-center p-2">
                            <img src="https://cdn-icons-png.flaticon.com/128/4117/4117258.png" alt="">
                        </h3>
                    </div>
                    <div class="col-md-9 col-12">
                        <label class="text-secondary text-sm"><i>Informasi Distribusi</i></label>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <h6 class="mb-0 text-sm">Unit Kerja</h6>
                                <label class="text-sm text-capitalize mb-0">{{ $data->user->pegawai->uker->unit_kerja }}</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <h6 class="mb-0 text-sm">Kode</h6>
                                <label class="text-sm">{{ $data->kode }}</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <h6 class="mb-0 text-sm">Tanggal</h6>
                                <label class="text-sm">{{ Carbon\Carbon::parse($data->tanggal)->isoFormat('DD MMMM Y') }}</label>
                            </div>
                            <div class="col-md-12 form-group">
                                <h6 class="mb-0 text-sm">Keterangan</h6>
                                <label class="text-sm">{{ $data->keterangan }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom border-dark">
                <label class="text-secondary text-sm"><i>Detail Distribusi</i></label>
                <table id="table-data" class="table table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->detail->where('status','true') as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->atk->nama_barang }}</td>
                            <td class="text-left">{{ $row->atk->deskripsi }}</td>
                            <td>{{ $row->jumlah.$row->satuan->nama_satuan }}</td>
                        </tr>
                        @endforeach

                        @if($data->count())
                        <tr>
                            <td colspan="4">Tidak ada data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('atk-distribusi.edit', $data->id_distribusi) }}" class="btn btn-warning bg-main btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
