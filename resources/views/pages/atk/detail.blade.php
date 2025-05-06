@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Detail Barang
                        </label>
                    </div>
                    <div class="table-responsive small">
                        <div class="card-body border border-dark">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <label class="text-secondary">Informasi Barang</label><br>
                                    @if ($data->foto_barang)
                                    <img id="modal-foto" src="{{ asset('dist/img/foto_atk/'. $data->foto_barang) }}" alt="Foto Barang" class="img-fluid w-50">
                                    @else
                                    <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/512/679/679821.png" alt="Foto Barang" class="img-fluid w-50">
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3 my-1">ID</div>
                                        <div class="col-md-9 my-1">: {{ $data->id_atk }}</div>

                                        <div class="col-md-3 my-1">Kategori</div>
                                        <div class="col-md-9 my-1">: {{ $data->kategori->nama_kategori }}</div>

                                        <div class="col-md-3 my-1">Barang</div>
                                        <div class="col-md-9 my-1">: {{ $data->nama_barang }}</div>

                                        <div class="col-md-3 my-1">Deskripsi</div>
                                        <div class="col-md-9 my-1">: {{ $data->deskripsi }}</div>

                                        <div class="col-md-3 my-1">Harga</div>
                                        <div class="col-md-9 my-1">: {{ $data->harga }}</div>

                                        <div class="col-md-3 my-1">Satuan</div>
                                        <div class="col-md-9 my-1">: {{ $data->satuan->nama_satuan }}</div>

                                        <div class="col-md-3 my-1">Status</div>
                                        <div class="col-md-9 my-1">: {{ $data->status == 'true' ? 'Tersedia' : 'Tidak Tersedia' }}</div>

                                        <div class="col-md-3 my-1">Sisa Stok</div>
                                        <div class="col-md-9 my-1">: {{ $data->stok().' '.$data->satuan->nama_satuan }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <div class="card card-primary">
                        <div class="card-header border border-dark">
                            <label class="card-title">
                                Pembelian
                            </label>
                            <div class="card-tools">
                                Total : {{ $data->stokMasuk->sum('jumlah') }} {{ $data->satuan->nama_satuan }}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="card-body border border-dark">
                                <div class="table-responsive">
                                    <table id="table-beli" class="table table-bordered border border-dark">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-xs">
                                            @foreach ($data->stokMasuk as $row)
                                            <tr class="bg-white">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ Carbon\Carbon::parse($row->stok->tanggal_beli)->isoFormat('DD MMMM Y') }}</td>
                                                <td>{{ $row->stok->keterangan }}</td>
                                                <td>{{ $row->atk->kategori->nama_kategori }} {{ $row->atk->nama_barang }}</td>
                                                <td>{{ $row->atk->deskripsi }}</td>
                                                <td class="text-center">
                                                    {{ number_format($row->jumlah, 0, '.') }} {{ $row->atk->satuan->nama_satuan }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="card card-primary">
                        <div class="card-header border border-dark">
                            <label class="card-title">
                                Permintaan
                            </label>
                            <div class="card-tools">
                                Total : {{ $data->stokKeluar->sum('jumlah') }} {{ $data->satuan->nama_satuan }}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="card-body border border-dark">
                                <div class="table-responsive">
                                    <table id="table-permintaan" class="table table-bordered border border-dark">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Kode</th>
                                                <th>Uker</th>
                                                <th>Keterangan</th>
                                                <th>Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-xs">
                                            @foreach ($data->stokKeluar as $row)
                                            <tr class="bg-white">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ Carbon\Carbon::parse($row->tanggal_beli)->isoFormat('DD MMMM Y') }}</td>
                                                <td>{{ $row->usulan->kode_usulan }}</td>
                                                <td>{{ $row->usulan->user->pegawai->uker->unit_kerja }}</td>
                                                <td>{{ $row->usulan->keterangan }}</td>
                                                <td>{{ $row->atk->kategori->nama_kategori }} {{ $row->atk->nama_barang }}</td>
                                                <td>{{ $row->atk->deskripsi }}</td>
                                                <td class="text-center">
                                                    {{ number_format($row->jumlah, 0, '.') }} {{ $row->atk->satuan->nama_satuan }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 form-group">

            </div>
        </div>
    </div>
</section>
@section('js')
<script>
    $("#table-beli").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger',
            title: 'Pegawai'
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'Pegawai',
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-beli_wrapper .col-md-6:eq(0)');

    $("#table-permintaan").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger',
            title: 'Pegawai'
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'Pegawai',
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-permintaan_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
