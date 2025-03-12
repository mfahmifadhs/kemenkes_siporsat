@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar Satuan</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Satuan</li>
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
                            Daftar Satuan
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="table" class="table table-bordered text-center">
                                <thead class="text-uppercase text-xs">
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Nama Satuan</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="#" class="btn btn-default btn-xs bg-warning border-dark rounded" data-toggle="modal" data-target="#editModal-{{ $row->id_satuan }}">
                                                <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                                            </a>
                                        </td>
                                        <td class="text-left">{{ $row->nama_satuan }}</td>
                                        <td class="text-left">{{ $row->deskripsi }}</td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah Satuan</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('atk-satuan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="satuan" class="col-form-label">Nama Satuan:</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($data as $row)
<div class="modal fade" id="editModal-{{ $row->id_satuan }}" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Edit Kategori</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate-{{ $row->id_satuan }}" action="{{ route('atk-satuan.update', $row->id_satuan) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="satuan" class="col-form-label">Nama Satuan:</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $row->nama_satuan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $row->deskripsi }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'formUpdate-{{ $row->id_satuan }}')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
        }, {
            text: ' Tambah',
            className: 'bg-primary',
            action: function(e, dt, button, config) {
                $('#createModal').modal('show');
            }
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
