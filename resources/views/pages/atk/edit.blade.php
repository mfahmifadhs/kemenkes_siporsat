@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Barang</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('atk-barang') }}"> Daftar</a></li>
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
                            Edit Barang
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('atk-barang.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-5">
                                        @if ($data->foto_barang)
                                        <img id="modal-foto" src="{{ asset('dist/img/foto_atk/'. $data->foto_barang) }}" alt="Foto Barang" class="img-fluid">
                                        @else
                                        <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/512/679/679821.png" alt="Foto Barang" class="img-fluid">
                                        @endif

                                        <div class="btn btn-warning btn-block btn-sm mt-1 btn-file border-dark">
                                            <i class="fas fa-paperclip"></i> Upload Foto
                                            <input type="file" name="foto" class="previewImg" data-preview="modal-foto" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <label class="col-md-12 text-secondary">Informasi Barang</label>

                                            <div class="col-md-3 col-form-label my-1">ID</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-id" class="form-control" name="id_atk" value="{{ $data->id_atk }}" readonly>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Kategori</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="kategori" id="input-kategori" class="form-control">
                                                    @foreach ($kategori as $row)
                                                    <option value="{{ $row->id_kategori }}" <?= $row->id_kategori == $data->kategori_id ? 'selected' : '';  ?>>
                                                        {{ $row->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Barang</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-barang" class="form-control" name="nama_barang" value="{{ $data->nama_barang }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Deskripsi</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-deskripsi" class="form-control" name="deskripsi" value="{{ $data->deskripsi }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Harga</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-harga" class="form-control number" name="harga" value="{{ $data->harga }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Satuan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="satuan" id="input-satuan" class="form-control">
                                                    @foreach ($satuan as $row)
                                                    <option value="{{ $row->id_satuan }}" <?= $row->id_satuan == $data->satuan_id ? 'selected' : '';  ?>>
                                                        {{ $row->nama_satuan }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Jumlah Maksimal</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-harga" class="form-control number" name="maksimal" value="{{ $data->jumlah_maks }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Keterangan</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <input type="text" id="input-keterangan" class="form-control" name="keterangan" value="{{ $data->keterangan }}">
                                            </div>

                                            <div class="col-md-3 col-form-label my-1">Status</div>
                                            <div class="col-md-1 col-form-label my-1">:</div>
                                            <div class="col-md-8 my-1">
                                                <select name="status" id="input-status" class="form-control">
                                                    <option value="true" <?= $data->status == 'true' ? 'selected' : '';  ?>>Tersedia</option>
                                                    <option value="false" <?= $data->status == 'false' ? 'selected' : '';  ?>>Tidak Tersedia</option>
                                                </select>
                                            </div>
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
