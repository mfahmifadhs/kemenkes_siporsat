@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Informasi</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
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
                            Edit Informasi
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('profil.update', $data->id) }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="pegawai" class="col-form-label">Pilih Pegawai:</label>
                                        <select class="form-control pegawai" name="pegawai" style="width: 100%;" disabled>
                                            <option value="{{ $data->pegawai_id }}">
                                                {{ $data->pegawai->uker->unit_kerja }} - {{ $data->pegawai->nama_pegawai }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="username" class="col-form-label">Username:</label>
                                        <input id="username" type="text" class="form-control" name="username" value="{{ $data->username }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control border-dark rounded password" name="password" value="{{ $data->password_teks }}" placeholder="Masukkan Password" required>
                                            <div class="input-group-append border rounded border-dark">
                                                <span class="input-group-text h-100 rounded-0 bg-white">
                                                    <i class="fas fa-eye eye-icon-pass"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="keterangan" class="col-form-label">Keterangan:</label>
                                        <input id="keterangan" type="text" class="form-control" name="keterangan" value="{{ $data->keterangan }}">
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
