@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar Pembelian</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Pembelian</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header">
                        <label class="card-title">
                            Daftar Pembelian
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="table" class="table table-bordered text-xs text-center">
                                <thead class="text-uppercase">
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Tanggal</th>
                                        <th>No. Kwitansi</th>
                                        <th>Total Barang</th>
                                        <th>Total Harga</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('atk-stok.detail', $row->id_stok) }}" class="btn btn-default btn-xs bg-primary rounded border-dark">
                                                <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                                            </a>'
                                            <a href="{{ route('atk-stok.edit', $row->id_stok) }}" class="btn btn-default btn-xs bg-warning rounded border-dark">
                                                <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                                            </a>'
                                            <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark" onclick="confirmLink(event, `{{ route('atk-stok.delete', $row->id_stok) }}`)">
                                                <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                            </a>'
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($row->tanggal_masuk)->isoFormat('DD MMMM Y') }}</td>
                                        <td>{{ $row->no_kwitansi }}</td>
                                        <td>{{ $row->detail->count() }} barang</td>
                                        <td>Rp {{ number_format($row->total_harga, 0, '.') }}</td>
                                        <td>{{ $row->keterangan }}</td>
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
</section>

@section('js')
<script>
    $("#table").DataTable({
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
            title: 'penyedia',
            exportOptions: {
                columns: [0, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'penyedia',
            exportOptions: {
                columns: ':not(:nth-child(2))'
            },
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
