@extends('layouts.app')

@section('content')


<div class="content-header">
    <div class="container col-md-9">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Stok</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('atk-stok') }}">Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container col-md-9">
        <div class="card border border-dark">
            <div class="card-header">
                <label class="mt-2">
                    Detail Stok
                </label>
                <div class="card-tools mt-2">
                    <a href="{{ route('atk-stok.edit', $data->id_stok) }}" class="btn btn-warning border-dark btn-xs mt-0 p-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <a href="#" class="btn btn-danger border-dark btn-xs mt-0 p-1" onclick="confirmLink(event, `{{ route('atk-stok.delete', $data->id_stok) }}`)">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                </div>
            </div>
            <div class="card-body small text-capitalize">
                <div class="d-flex">
                    <div class="w-50 text-left">
                        <label class="text-secondary">Detail Naskah</label>
                    </div>
                    <div class="w-50 text-right text-secondary">
                        #{{ Carbon\Carbon::parse($data->created_at)->format('dmyHis').$data->id_stok }}-{{ $data->id_stok }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <label class="w-25">Tanggal Masuk</label>
                            <span class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_masuk)->isoFormat('DD MMMM Y') }}</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Nomor Kwitansi</label>
                            <span class="w-75">: {{ $data->no_kwitansi }}</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Total Barang</label>
                            <span class="w-75">: {{ $data->detail->count() }} barang</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Total Harga</label>
                            <span class="w-75">: Rp {{ number_format($data->total_harga, 0, '.') }}</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Keterangan</label>
                            <span class="w-75">: {{ $data->keterangan }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body small">
                <label>Daftar Barang</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detail as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->atk->kategori->nama_kategori }} {{ $row->atk->nama_barang }}</td>
                                <td>{{ $row->atk->deskripsi }}</td>
                                <td class="text-center">{{ number_format($row->jumlah, 0, '.') }}</td>
                                <td class="text-center">{{ $row->atk->satuan->nama_satuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')

<script>
    function confirm(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus',
            text: '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection

@endsection
