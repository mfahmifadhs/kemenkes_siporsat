@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar Users</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                            Daftar Users
                        </label>

                        <div class="card-tools">
                            <a href="" class="btn btn-default btn-sm text-dark" data-toggle="modal" data-target="#modalFilter">
                                <i class="fas fa-filter"></i> Filter
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="table-data" class="table table-bordered text-xs text-center">
                                <thead class="text-uppercase text-center">
                                    <tr>
                                        <th style="width: 0%;">No</th>
                                        <th style="width: 10%;">Aksi</th>
                                        <th style="width: 10%;">Role</th>
                                        <th style="width: 10%;">Unit Kerja</th>
                                        <th style="width: auto;">Nama</th>
                                        <th style="width: 20%;">Jabatan</th>
                                        <th style="width: auto;">Username</th>
                                        <th style="width: auto;">Keterangan</th>
                                        <th style="width: 10%;">Akses</th>
                                        <th style="width: 0%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data == 0)
                                    <tr class="text-center">
                                        <td colspan="13">Tidak ada data</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="13">Sedang mengambil data ...</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-filter"></i> Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('pegawai') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Pilih Unit Kerja</label>
                        <select id="uker" name="uker" class="form-control" style="width: 100%;">
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach ($listUker as $row)
                            <option value="{{ $row->id_unit_kerja }}" <?php echo $row->id_unit_kerja == $uker ? 'selected' : ''; ?>>
                                {{ $row->unit_kerja }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Pilih Jabatan</label>
                        <select name="jabatan" class="form-control">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach ($listJabatan as $row)
                            <option value="{{ $row->id_jabatan }}" <?php echo $row->id_jabatan == $jabatan ? 'selected' : ''; ?>>
                                {{ $row->jabatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Pilih Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="true" <?php echo $status == 'true' ? 'selected' : ''; ?>>True</option>
                            <option value="false" <?php echo $status == 'false' ? 'selected' : ''; ?>>False</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('pegawai') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Muat
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="pegawai" class="col-form-label">Pilih Pegawai:</label>
                            <select class="form-control pegawai" name="pegawai" style="width: 100%;" required>
                                <option value="">-- Cari Pegawai --</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="role" class="col-form-label">Pilih Role:</label>
                            <select class="form-control" name="role" required>
                                @foreach ($role as $row)
                                <option value="{{ $row->id_role }}">{{ $row->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="akses" class="col-form-label">Pilih Akses:</label>
                            <select class="form-control" name="akses">
                                <option value="">Tidak ada</option>
                                @foreach ($akses as $row)
                                <option value="{{ $row->id_akses }}">{{ $row->nama_akses }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="username" class="col-form-label">Username:</label>
                            <input id="username" type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="password" class="col-form-label">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control border-dark rounded password" name="password" placeholder="Masukkan Password" required>
                                <div class="input-group-append border rounded border-dark">
                                    <span class="input-group-text h-100 rounded-0 bg-white">
                                        <i class="fas fa-eye eye-icon-pass"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="keterangan" class="col-form-label">Keterangan:</label>
                            <input id="keterangan" type="text" class="form-control" name="keterangan">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="col-form-label">Status:</label> <br>
                            <div class="input-group">
                                <input type="radio" id="true" name="status" value="true">
                                <label for="true" class="my-auto ml-2 mr-5">Aktif</label>

                                <input type="radio" id="false" name="status" value="false">
                                <label for="false" class="my-auto ml-2">Tidak Aktif</label>
                            </div>
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
        let uker = $('[name="uker"]').val();
        let jabatan = $('[name="jabatan"]').val();
        let status = $('[name="status"]').val();

        loadTable(uker, jabatan, status);

        function loadTable(uker, jabatan, status) {
            $.ajax({
                url: `{{ route('users.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    jabatan: jabatan,
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
                                    <td class="align-middle">${item.role}</td>
                                    <td class="align-middle">${item.uker}</td>
                                    <td class="align-middle text-left">${item.nama} </td>
                                    <td class="align-middle text-left">${item.jabatan} ${item.timker}</td>
                                    <td class="align-middle text-left">${item.username}</td>
                                    <td class="align-middle text-left">${item.keterangan}</td>
                                    <td class="align-middle text-left">${item.akses}</td>
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

<script>
    $(document).ready(function() {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        $(".pegawai").select2({
            placeholder: "Cari Pegawai...",
            allowClear: true,
            ajax: {
                url: "{{ route('pegawai.select') }}",
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    }
                },
                processResults: function(response) {
                    return {
                        results: response.map(function(item) {
                            return {
                                id: item.id,
                                text: item.uker + ' - ' + item.nama
                            };
                        })
                    };
                },
                cache: true
            }
        })

        $(".pegawai").each(function() {
            let selectedId = $(this).find("option:selected").val();
            let selectedText = $(this).find("option:selected").text();

            if (selectedId) {
                let newOption = new Option(selectedText, selectedId, true, true);
                $(this).append(newOption).trigger('change');
            }
        });
    });
</script>
@endsection
@endsection
