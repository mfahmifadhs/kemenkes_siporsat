@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar Kategori</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
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
                            Daftar Kategori
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="table" class="table table-bordered text-center">
                                <thead class="text-uppercase text-xs">
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Nama Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="#" class="btn btn-default btn-xs bg-warning border-dark rounded" data-toggle="modal" data-target="#editModal-{{ $row->id_kategori }}">
                                                <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                                            </a>
                                        </td>
                                        <td class="text-left">{{ $row->nama_kategori }}</td>
                                        <td class="text-left">{{ $row->deskripsi }}</td>
                                        <td>
                                            <img src="{{ $row->icon }}" width="30">
                                        </td>
                                        <td>{{ $row->status }}</td>
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
                <h5 class="modal-title" id="createModal">Tambah Kategori</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('bmhp-kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="col-form-label">Nama Kategori:</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="col-form-label">Icon:</label>
                        <input type="text" class="form-control" id="icon" name="icon" required>
                    </div>
                    <div class="mb-3">
                            <label class="col-form-label">Status:</label> <br>
                            <div class="input-group">
                                <input type="radio" id="true" name="status" value="true">
                                <label for="true" class="my-auto ml-2 mr-5">Aktif</label>

                                <input type="radio" id="false" name="status" value="false">
                                <label for="false" class="my-auto ml-2">Tidak Aktif</label>
                            </div>
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
<div class="modal fade" id="editModal-{{ $row->id_kategori }}" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Edit Kategori</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate-{{ $row->id_kategori }}" action="{{ route('bmhp-kategori.update', $row->id_kategori) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="kategori" class="col-form-label">Nama Kategori:</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $row->nama_kategori }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $row->deskripsi }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="col-form-label">Icon:</label>
                            <input type="text" class="form-control" id="icon" name="icon" value="{{ $row->icon }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Status:</label>
                            <div class="input-group">
                                <input type="radio" id="true" name="status" value="true" <?php echo $row->status == 'true' ? 'checked' : ''; ?>>
                                <label for="true" class="my-auto ml-2 mr-5">Aktif</label>

                                <input type="radio" id="false" name="status" value="false" <?php echo $row->status == 'false' ? 'checked' : ''; ?>>
                                <label for="false" class="my-auto ml-2">Tidak Aktif</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'formUpdate-{{ $row->id_kategori }}')">Submit</button>
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
