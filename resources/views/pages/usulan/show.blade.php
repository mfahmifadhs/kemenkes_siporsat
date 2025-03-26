@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Daftar Usulan</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Usulan</li>
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
                            Daftar Usulan {{ $form->nama_form }}
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
                                        <th style="width: auto;">Kode</th>
                                        <th style="width: auto;">Unit Kerja</th>
                                        <th style="width: auto;">Tanggal</th>
                                        <th style="width: auto;">Nomor</th>
                                        <th style="width: auto;">Hal</th>
                                        <th style="width: auto;" class="d-none">Deskripsi</th>
                                        <th style="width: 10%;">Status</th>
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
<div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-filter"></i> Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('usulan', $form->kode_form) }}">
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
                        <label class="col-form-label">Pilih Bulan</label>
                        <select name="bulan" class="form-control border-dark rounded">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $monthNumber)
                            @php $rowBulan = Carbon\Carbon::create()->month($monthNumber); @endphp
                            <option value="{{ $rowBulan->isoFormat('MM') }}" <?php echo $bulan == $rowBulan->isoFormat('M') ? 'selected' : '' ?>>
                                {{ $rowBulan->isoFormat('MMMM') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Pilih Tahun</label>
                        <select name="tahun" class="form-control border-dark rounded">
                            <option value="">Semua Tahun</option>
                            @foreach(range(2025,2026) as $yearNumber)
                            @php $rowTahun = Carbon\Carbon::create()->year($yearNumber); @endphp
                            <option value="{{ $rowTahun->isoFormat('Y') }}" <?php echo $tahun == $rowTahun->isoFormat('Y') ? 'selected' : '' ?>>
                                {{ $rowTahun->isoFormat('Y') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Pilih Status</label>
                        <select name="status" class="form-control">
                            <option value="">Seluruh Status</option>
                            <option value="verif" <?php echo $status == 'verif' ? 'selected' : ''; ?>>Persetujuan</option>
                            <option value="proses" <?php echo $status == 'proses' ? 'selected' : ''; ?>>Proses</option>
                            <option value="selesai" <?php echo $status == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="false" <?php echo $status == 'false' ? 'selected' : ''; ?>>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('usulan', $form->kode_form) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Muat
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>\

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
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>

<script>
    $(document).ready(function() {
        let role    = '{{ auth()->user()->role_id }}';
        let form    = '{{ $form->kode_form }}';
        let formId  = '{{ $formId }}';
        let bulan   = $('[name="bulan"]').val();
        let tahun   = $('[name="tahun"]').val();
        let uker    = $('[name="uker"]').val();
        let status  = $('[name="status"]').val();

        loadTable(formId, bulan, tahun, uker, status);

        function loadTable(formId, bulan, tahun, uker, status) {
            $.ajax({
                url: `{{ route('usulan.select', ':form') }}`.replace(':form', form),
                method: 'GET',
                data: {
                    formId: formId,
                    bulan: bulan,
                    tahun: tahun,
                    uker: uker,
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
                                    <td class="align-middle">${item.kode}</td>
                                    <td class="align-middle">${item.uker}</td>
                                    <td class="align-middle">${item.tanggal}</td>
                                    <td class="align-middle">${item.nosurat}</td>
                                    <td class="align-middle text-left">${item.hal}</td>
                                    <td class="align-middle text-left d-none">${item.deskripsi}</td>
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
                            },
                            (role == 4 && form != 'atk' ? [{
                                text: ' Tambah',
                                className: 'bg-primary',
                                action: function(e, dt, button, config) {
                                    window.location.href = `{{ route('usulan.create', ':form') }}`.replace(':form', form)
                                }
                            }] : []),
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
