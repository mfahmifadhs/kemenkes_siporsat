@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar AADB</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar</li>
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
                            Daftar AADB
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
                                        <th style="width: auto;">Aksi</th>
                                        <th style="width: auto;">Unit Kerja</th>
                                        <th style="width: auto;">Jenis</th>
                                        <th style="width: auto;">Kendaraan</th>
                                        <th style="width: auto;">Merk/Tipe</th>
                                        <th style="width: auto;">Kualifikasi</th>
                                        <th style="width: auto;">No.Polisi</th>
                                        <th style="width: auto;">Tanggal</th>
                                        <th style="width: auto;">Nilai</th>
                                        <th style="width: auto;">Kondisi</th>
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
            <form method="GET" action="{{ route('aadb') }}">
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
                        <label class="col-form-label">Pilih Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($listKategori as $row)
                            <option value="{{ $row->id_kategori }}" <?php echo $row->id_kategori == $kategori ? 'selected' : ''; ?>>
                                {{ $row->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Pilih Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="">-- Pilih Kondisi --</option>
                            @foreach ($listKondisi as $row)
                            <option value="{{ $row->id_kondisi }}" <?php echo $row->id_kondisi == $kondisi ? 'selected' : ''; ?>>
                                {{ $row->nama_kondisi }}
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
                    <a href="{{ route('aadb') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Muat
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="uker" class="col-form-label">Unit Kerja:</label>
                            <select name="uker" class="form-control" id="uker">
                                <option value="">-- Pilih Unit Kerja --</option>
                                @foreach($listUker as $row)
                                <option value="{{ $row->id_unit_kerja }}">
                                    {{ $row->unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="pegawai" class="col-form-label">*Nama Pegawai:</label>
                            <input type="text" class="form-control" id="pegawai" name="pegawai" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="nip" class="col-form-label">NIP:</label>
                            <input type="text" class="form-control number" id="nip" name="nip" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="kategori" class="col-form-label">Kategori:</label>
                            <select name="kategori" class="form-control" id="kategori">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($listKategori as $row)
                                <option value="{{ $row->id_kategori }}">{{ $row->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="timker" class="col-form-label">Tim Kerja:</label>
                            <input id="timker" type="text" class="form-control" name="timker">
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
        let uker     = $('[name="uker"]').val();
        let kategori = $('[name="kategori"]').val();
        let status   = $('[name="status"]').val();
        let kondisi  = $('[name="kondisi"]').val();
        let userRole = '{{ Auth::user()->role_id }}';

        loadTable(uker, kategori, status, kondisi);

        function loadTable(uker, kategori, status, kondisi) {
            $.ajax({
                url: `{{ route('aadb.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    kategori: kategori,
                    status: status,
                    kondisi: kondisi
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
                                    <td class="align-middle">${item.no} ${item.status}</td>
                                    <td class="align-middle">${item.aksi}</td>
                                    <td class="align-middle text-left">${item.uker}</td>
                                    <td class="align-middle">${item.jenis}</td>
                                    <td class="align-middle text-left">${item.kategori}</td>
                                    <td class="align-middle text-left">${item.merktipe}</td>
                                    <td class="align-middle">${item.kualifikasi}</td>
                                    <td class="align-middle">${item.nopolisi}</td>
                                    <td class="align-middle">${item.tanggal}</td>
                                    <td class="align-middle text-left">${item.nilai}</td>
                                    <td class="align-middle">${item.kondisi}</td>
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
                                },
                                userRole == 1 || userRole == 2 ? {
                                    text: ' Tambah',
                                    className: 'bg-primary',
                                    action: function(e, dt, button, config) {
                                        window.location.href = `{{ route('aadb.create') }}`;
                                    }
                                } : null
                            ],
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
