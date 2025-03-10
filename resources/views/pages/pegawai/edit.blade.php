@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Pegawai</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('pegawai') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                            Edit Pegawai
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('pegawai.update', $data->id_pegawai) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="uker" class="col-form-label">Unit Kerja:</label>
                                        <select name="uker" class="form-control" id="uker">
                                            <option value="">-- Pilih Unit Kerja --</option>
                                            @foreach($uker as $row)
                                            <option value="{{ $row->id_unit_kerja }}" <?php echo $data->uker_id == $row->id_unit_kerja ? 'selected' : ''; ?>>
                                                {{ $row->unit_kerja }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="pegawai" class="col-form-label">*Nama Pegawai:</label>
                                        <input type="text" class="form-control" id="pegawai" name="pegawai" value="{{ $data->nama_pegawai }}" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nip" class="col-form-label">NIP:</label>
                                        <input type="text" class="form-control number" id="nip" name="nip" value="{{ $data->nip }}" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jabatan" class="col-form-label">Jabatan:</label>
                                        <select name="jabatan" class="form-control" id="jabatan">
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach($jabatan as $row)
                                            <option value="{{ $row->id_jabatan }}" <?php echo $data->jabatan_id == $row->id_jabatan ? 'selected' : ''; ?>>
                                                {{ $row->jabatan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="timker" class="col-form-label">Tim Kerja:</label>
                                        <input id="timker" type="text" class="form-control" name="timker" value="{{ $data->tim_kerja }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-form-label">Status:</label> <br>
                                        <div class="input-group">
                                            <input type="radio" id="true" name="status" value="true" <?php echo $data->status == 'true' ? 'checked' : ''; ?>>
                                            <label for="true" class="my-auto ml-2 mr-5">Aktif</label>

                                            <input type="radio" id="false" name="status" value="false" <?php echo $data->status == 'false' ? 'checked' : ''; ?>>
                                            <label for="false" class="my-auto ml-2">Tidak Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border border-dark text-right">
                                <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $("#uker").select2()
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
            title: 'Pegawai',
            exportOptions: {
                columns: [0, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'Pegawai',
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

<script>
    $(document).ready(function() {
        let penyedia = $('#penyedia').val();
        let posisi = $('#posisi').val();
        let status = $('#status').val();

        loadTable(penyedia, posisi, status);

        function loadTable(penyedia, posisi, status) {
            $.ajax({
                url: `{{ route('pegawai.select') }}`,
                method: 'GET',
                data: {
                    penyedia: penyedia,
                    posisi: posisi,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('.table tbody');
                    tbody.empty();

                    if (response.message) {
                        tbody.append(`
                        <tr>
                            <td colspan="9">${response.message}</td>
                        </tr>
                    `);
                    } else {
                        // Jika ada data
                        $.each(response, function(index, item) {
                            let actionButton = '';
                            let deleteUrl = "{{ route('pegawai.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark"
                                onclick="confirmRemove(event, '${deleteUrl}')">
                                    <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle">${item.no}</td>
                                    <td class="align-middle">${item.aksi}</td>
                                    <td class="align-middle">${item.penyedia}</td>
                                    <td class="align-middle">${item.foto}</td>
                                    <td class="align-middle text-left">${item.kode}</td>
                                    <td class="align-middle text-left">${item.posisi}</td>
                                    <td class="align-middle text-left">${item.pegawai}</td>
                                    <td class="align-middle">${item.nip}</td>
                                    <td class="align-middle">${item.jenisKelamin}</td>
                                    <td class="align-middle">${item.email}</td>
                                    <td class="align-middle">${item.notelp}</td>
                                    <td class="align-middle">${item.status}</td>
                                </tr>
                            `);
                        });

                        $("#table-data").DataTable({
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
                                title: 'kegiatan',
                                exportOptions: {
                                    columns: [0, 2, 3, 4],
                                },
                            }, {
                                extend: 'excel',
                                text: ' Excel',
                                className: 'bg-success',
                                title: 'kegiatan',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5, 6, 7, 8],
                                },
                            }, {
                                text: ' Tambah',
                                className: 'bg-primary',
                                action: function(e, dt, button, config) {
                                    $('#createModal').modal('show');
                                }
                            }, ],
                            "bDestroy": true
                        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
@endsection
@endsection
