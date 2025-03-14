@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Distribusi ATK</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('atk-distribusi') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('atk-distribusi', $id) }}"> Detail</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>

            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container col-md-9">
        <div class="card border border-dark">
            <div class="card-header">
                <label class="mt-2">
                    Edit Kegiatan
                </label>
            </div>
            <form id="form-submit" action="{{ route('atk-distribusi.update', $id) }}" method="POST">
                @csrf
                <div class="card-body text-capitalize">
                    <div class="d-flex">
                        <div class="w-50 text-left">
                            <label class="text-secondary"><i>Informasi Distribusi</i></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <label class="w-25 col-form-label">Kode</label>
                                <span class="w-75 input-group"><span class="col-form-label mx-2">:</span>
                                    <input type="text" class="form-control rounded" value="{{ $data->kode }}" readonly>
                                </span>
                            </div>

                            <div class="input-group mt-2">
                                <label class="w-25 col-form-label">Tanggal</label>
                                <span class="w-75 input-group"><span class="col-form-label mx-2">:</span>
                                    <input type="date" class="form-control rounded" name="tanggal" value="{{ Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}" required>
                                </span>
                            </div>

                            <div class="input-group mt-2">
                                <label class="w-25 col-form-label">Keterangan Distribusi</label>
                                <span class="w-75 input-group"><span class="col-form-label mx-2">:</span>
                                    <textarea id="keterangan" class="form-control rounded" name="keterangan" placeholder="Contoh : Distribusi Timker Dukman" required>{{ $data->keterangan }}</textarea>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body small">
                    <div class="d-flex">
                        <label class="w-50 text-secondary">
                            <i>Informasi Barang</i>
                        </label>
                        <label class="w-50 text-right">
                            <a href="#" class="btn btn-default btn-xs bg-primary rounded" data-toggle="modal" data-target="#tambahItem">
                                <i class="fas fa-plus-circle p-1" style="font-size: 12px;"></i> Tambah
                            </a>
                        </label>
                    </div>
                    <div class="table-responsive" style="max-height: 230px; overflow-y: auto;">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 10%;">Aksi</th>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 10%;">Jumlah</th>
                                    <th style="width: 10%;">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->detail)
                                @foreach($data->detail as $index => $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="#" class="btn btn-default btn-xs bg-primary rounded" data-toggle="modal" data-target="#editItem-{{ $row->id_detail }}">
                                            <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                                        </a>
                                        <a href="#" class="btn btn-default btn-xs bg-danger rounded" onclick="confirmRemove(event, `{{ route('atk-distribusi.item.delete', $row->id_detail) }}`)">
                                            <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                        </a>
                                    </td>
                                    <td class="text-left">{{ $row->atk->nama_barang }}</td>
                                    <td class="text-left">{{ $row->atk->deskripsi }}</td>
                                    <td>{{ number_format($row->jumlah, 0, '', '.') }}</td>
                                    <td>{{ $row->satuan->nama_satuan }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">Tidak ada data</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-sm" onclick="confirmSubmit(event, 'form-submit')">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


<!-- Modal Tambah -->
<div class="modal fade" id="tambahItem" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add" action="{{ route('atk-distribusi.item.store') }}" method="POST">
                @csrf
                <input type="hidden" name="distribusi_id" value="{{ $data->id_distribusi }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="w-25 col-form-label">Pilih Kategori</label>
                        <select name="" id="kategori-add" class="form-control kategori" style="width: 100%;" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $subRow)
                            <option value="{{ $subRow->id_kategori }}">
                                {{ $subRow->nama_kategori }}
                            </option>
                            @endforeach
                        </select>

                        <label class="col-form-label">Pilih Barang</label>
                        <select name="id_atk" id="barang-add" class="form-control barang" style="width: 100%;" required>
                            <option value="">-- Pilih Barang --</option>
                        </select>

                        <label class="col-form-label">Jumlah</label>
                        <div class="input-group">
                            <input type="number" class="form-control text-center w-50 number" name="jumlah" value="1" min="1" required>
                            <input type="text" class="form-control text-center w-25 ml-2 satuan" placeholder="satuan" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-add')">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($data->detail as $index => $row)
<div class="modal fade text-left" id="editItem-{{ $row->id_detail }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-sm">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-{{ $row->id_detail }}" action="{{ route('atk-distribusi.item.update', $row->id_detail) }}" method="POST">
                @csrf
                <input type="hidden" name="distribusi_id" value="{{ $row->distribusi_id }}">
                <div class="modal-body">
                    <div class="d-flex">
                        <label class="w-25 col-form-label">Pilih Kategori</label>
                        <select name="" id="kategori-{{ $index }}" class="w-75 form-control kategori" style="width: 75%;" disabled>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $subRow)
                            <option value="{{ $subRow->id_kategori }}" {{ $subRow->id_kategori == $row->snc->snc_kategori ? 'selected' : '' }}>
                                {{ $subRow->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex mt-2">
                        <label class="w-25 col-form-label">Pilih Barang</label>
                        <select name="id_snc" id="barang-{{ $index }}" class="w-75 form-control barang" style="width: 75%;" disabled>
                            <option value="{{ $row->snc_id }}">
                                {{ $row->snc->snc_nama }} {{ $row->snc->snc_deskripsi }}
                            </option>
                        </select>
                    </div>

                    <div class="d-flex mt-2">
                        <label class="w-25 col-form-label">Stok</label>
                        <input type="text" class="form-control text-center w-50 ml-1 stok" name="stok" placeholder="stok" value="{{ $row->snc->stokUker(Auth::user()->pegawai->uker_id) }}" readonly>
                        <input type="text" class="form-control text-center w-25 ml-2 satuan" value="{{ $row->snc->satuan->satuan }}" placeholder="satuan" readonly>
                    </div>

                    <div class="d-flex mt-2">
                        <label class="w-25 col-form-label">Jumlah</label>
                        <input type="number" class="form-control text-center w-50 ml-1 jumlah" name="jumlah" value="{{ $row->jumlah }}" min="1" required>
                        <input type="text" class="form-control text-center w-25 ml-2 satuan" value="{{ $row->snc->satuan->satuan }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-edit-{{ $row->id_detail }}')">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@section('js')

<script>
    $(document).ready(function() {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        $(".barang").select2({
            placeholder: "Cari Pegawai...",
            allowClear: true,
            ajax: {
                url: "{{ route('atk-stok.ready') }}",
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
                                text: item.nama_barang + ' - ' + item.nama
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

<script>
    function confirmRemove(event, url) {
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
                Swal.fire({
                    title: 'Proses...',
                    text: 'Mohon menunggu.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = url;
            }
        });
    }

    function confirmSubmit(event, formId) {
        event.preventDefault();

        const form = document.getElementById(formId);
        const stok = $(form).find('.stok').val();
        const jumlah = $(form).find('.jumlah').val();
        const sisa = stok - jumlah;
        const requiredInputs = form.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)');

        let allInputsValid = true;

        requiredInputs.forEach(input => {
            if (input.value.trim() === '') {
                input.style.borderColor = 'red';
                allInputsValid = false;
            } else {
                input.style.borderColor = '';
            }
        });

        if (allInputsValid) {
            if (sisa <= 0) {
                Swal.fire({
                    title: 'Error',
                    text: 'Stok Tidak Tersedia.',
                    icon: 'error'
                });
            } else {
                Swal.fire({
                    title: 'Submit',
                    text: '',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Proses...',
                            text: 'Mohon menunggu.',
                            icon: 'info',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Ada input yang diperlukan yang belum diisi.',
                icon: 'error'
            });
        }
    }
</script>
@endsection

@endsection
