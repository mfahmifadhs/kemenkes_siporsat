@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container col-md-9">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Usulan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan', 'atk') }}">Daftar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan.detail', $data->id_usulan) }}">Detail</a></li>
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
                    Edit Usulan
                </label>
            </div>
            <div class="card-header d-flex text-center flex-wrap justify-content-center">
                @php
                if (!$data->status_proses) {
                $verifikasi = 'bg-warning';
                } else if ($data->status_persetujuan == 'false') {
                $verifikasi = 'bg-danger';
                } else if ($data->status_persetujuan == 'true') {
                $verifikasi = 'bg-success';
                } else {
                $verifikasi = '';
                }
                @endphp
                <span class="w-25 w-md-25 border border-dark {{ $verifikasi }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-1 fa-3x"></i>
                    <b class="ms-3 ml-2">Verifikasi</b>
                </span>
                @php
                if ($data->status_proses == 'selesai') {
                $proses = 'bg-success';
                } else if ($data->status_persetujuan == 'true' && $data->status_proses == 'proses') {
                $proses = 'bg-warning';
                } else {
                $proses = '';
                }
                @endphp
                <span class="w-50 w-md-50 border border-dark {{ $proses }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-2 fa-3x"></i>
                    <b class="ms-3 ml-2">Proses</b>
                </span>
                @php
                if ($data->status_proses == 'selesai') {
                $selesai = 'bg-success';
                } else {
                $selesai = '';
                }
                @endphp
                <span class="w-25 w-md-25 border border-dark {{ $selesai }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-3 fa-3x"></i>
                    <b class="ms-3 ml-2">Selesai</b>
                </span>
                <!-- <span class="w-25 border border-secondary p-2">
                        <i class="fas fa-clock fa-3x {{ $data->status_persetujuan == 'true' ? 'text-warning' : 'text-dark' }}"></i>
                        <h6 class="text-xs text-uppercase mt-2 {{ $data->status_persetujuan == 'true' ? 'text-warning' : 'text-secondary' }}">
                            Proses {{ $data->kategori }}
                        </h6>
                    </span> -->
            </div>
            <div class="card-body small text-capitalize">
                <div class="d-flex">
                    <div class="w-50 text-left">
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-edit"></i></a>
                        @endif
                        <label>Detail Naskah</label>
                    </div>
                    <div class="w-50 text-right text-secondary">
                        #{{ Carbon\Carbon::parse($data->created_at)->format('dmyHis').$data->id_pengajuan }}-{{ $data->id_usulan }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <label class="w-25">Tanggal {{ $data->kategori }}</label>
                            <span class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_usulan)->isoFormat('DD MMMM Y') }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Nomor Naskah</label>
                            <span class="w-70 text-uppercase">: {{ $data->nomor_usulan }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Hal</label>
                            <span class="w-75">: {{ $data->form->nama_form }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Surat Usulan</label>
                            <span class="w-75">:
                                <a href="{{ route('usulan.surat', $data->id_usulan) }}" target="_blank">
                                    <u><i class="fas fa-file-alt"></i> Lihat Surat</u>
                                </a>
                            </span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Nama</label>
                            <span class="w-75">: {{ $data->user->pegawai->nama_pegawai }}</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Jabatan</label>
                            <span class="w-75">:
                                {{ ucwords(strtolower($data->user->pegawai->jabatan->jabatan)) }}
                                {{ ucwords(strtolower($data->user->pegawai->tim_kerja)) }}
                            </span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Unit Kerja</label>
                            <span class="w-75">:
                                {{ ucwords(strtolower($data->user->pegawai->uker->unit_kerja)) }} |
                                {{ ucwords(strtolower($data->user->pegawai->uker->utama->unit_utama)) }}
                            </span>
                        </div>
                        @if ($data->keterangan)
                        <div class="input-group">
                            <label class="w-25">Keterangan</label>
                            <span class="w-75">: {{ $data->keterangan }}</span>
                        </div>
                        @endif

                        @if ($data->status_persetujuan == 'false')
                        <div class="input-group">
                            <label class="w-25">Alasan Ditolak</label>
                            <span class="w-75 text-danger">: {{ $data->keterangan_tolak }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if (!$data->tanggal_ambil)
                        <div class="input-group">
                            <label class="w-50">Tanggal Terima</label>
                            <span class="w-50">: {{ Carbon\Carbon::parse($data->tanggal_ambil)->isoFormat('DD MMMM Y') }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-50">Nama Penerima</label>
                            <span class="w-50">: {{ $data->nama_penerima }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-50">Jabatan</label>
                            <span class="w-50">: Staf</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body small">
                <div class="d-flex">
                    <label class="w-50">
                        <i class="fas fa-boxes"></i> Daftar Barang
                    </label>
                    <label class="w-50 text-right">
                        <a href="#" class="btn btn-default btn-xs bg-primary rounded" data-toggle="modal" data-target="#tambahItem">
                            <i class="fas fa-plus-circle p-1" style="font-size: 12px;"></i> Tambah
                        </a>
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 10%;">Aksi</th>
                                <th style="width: 20%;">Nama Barang</th>
                                <th style="width: 30%;">Deskripsi</th>
                                <th style="width: 10%;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->detailAtk as $index => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="#" class="btn btn-default btn-xs bg-primary rounded" data-toggle="modal" data-target="#editItem-{{ $row->id_detail }}">
                                        <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                                    </a>
                                    <a href="#" class="btn btn-default btn-xs bg-danger rounded" onclick="confirmRemove(event, `{{ route('usulan-atk.delete', $row->id_detail) }}`)">
                                        <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                    </a>

                                    <div class="modal fade text-left" id="editItem-{{ $row->id_detail }}" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="form-edit-{{ $row->id_detail }}" action="{{ route('usulan-atk.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="usulan_id" value="{{ $data->id_usulan }}">
                                                    <input type="hidden" name="id_detail" value="{{ $row->id_detail }}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Pilih Barang</label>
                                                            <select name="" id="kategori-{{ $index }}" class="form-control kategori" style="width: 100%;" required>
                                                                <option value="">-- Pilih Barang --</option>
                                                                @foreach ($kategori as $subRow)
                                                                <option value="{{ $subRow->id_kategori }}" {{ $subRow->id_kategori == $row->atk->kategori_id ? 'selected' : '' }}>
                                                                    {{ $subRow->nama_kategori }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                            <label class="col-form-label">Pilih Merk</label>
                                                            <select name="id_atk" id="barang-{{ $index }}" class="form-control barang" style="width: 100%;" required>
                                                                <option value="{{ $row->atk_id }}">
                                                                    {{ $row->atk->nama_barang }}
                                                                </option>
                                                            </select>

                                                            <label class="col-form-label">Jumlah</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control text-center rounded ml-1" name="jumlah" value="{{ $row->jumlah }}" min="1" required>
                                                                <input type="text" class="form-control text-center rounded ml-2 showSatuan" value="{{ $row->satuan->nama_satuan }}" readonly>
                                                            </div>
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
                                </td>
                                <td class="text-left">{{ $row->atk->kategori->nama_kategori }}</td>
                                <td class="text-left">{{ $row->atk->nama_barang.' '.$row->atk->deskripsi }}</td>
                                <td>{{ $row->jumlah }} {{ $row->satuan->nama_satuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            <form id="form-add" action="{{ route('usulan-atk.store') }}" method="POST">
                @csrf
                <input type="hidden" name="usulan_id" value="{{ $data->id_usulan }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Pilih Barang</label>
                        <select name="" id="kategori-add" class="form-control kategori" style="width: 100%;" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($kategori as $subRow)
                            <option value="{{ $subRow->id_kategori }}">
                                {{ $subRow->nama_kategori }}
                            </option>
                            @endforeach
                        </select>

                        <label class="col-form-label">Pilih Merk</label>
                        <select name="id_atk" id="barang-add" class="form-control barang" style="width: 100%;" required>
                            <option value="">-- Pilih Barang --</option>
                        </select>

                        <label class="col-form-label">Jumlah</label>
                        <div class="input-group">
                            <input type="number" class="form-control text-center rounded" name="jumlah" value="1" min="1" required>
                            <input type="text" class="form-control text-center rounded ml-2 showSatuan" readonly>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Usulan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit" action="{{ route('usulan.update', $data->id_usulan) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_usulan">Tanggal Usulan</label>
                        <input id="tanggal_usulan" type="date" class="form-control" name="tanggal_usulan" value="{{ Carbon\Carbon::parse($data->tanggal_usulan)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_ambil">Tanggal Ambil</label>
                        <input id="tanggal_ambil" type="date" class="form-control" name="tanggal_ambil" value="{{ Carbon\Carbon::parse($data->tanggal_ambil)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_penerima">Nama Penerima</label>
                        <input id="nama_penerima" type="text" class="form-control" name="nama_penerima" value="{{ $data->nama_penerima }}">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form-edit')">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk semua elemen dengan class kategori dan barang
        $('.kategori, .barang').select2();

        // Event listener untuk elemen kategori
        $(document).on('change', '.kategori', function() {
            var kategoriId = $(this).val();
            var index = $(this).attr('id').split('-')[1]; // Ambil indeks dari ID

            $.ajax({
                url: '/atk/select-detail/' + kategoriId,
                type: 'GET',
                success: function(data) {
                    var barangSelect = $('#barang-' + index);
                    barangSelect.empty();
                    $.each(data, function(key, val) {
                        barangSelect.append('<option value="' + val.id + '" data-satuan="' + val.satuan + '">' + val.text + '</option>');
                    });

                    // Refresh Select2 untuk barang
                    barangSelect.select2();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Event listener untuk elemen barang
        $(document).on('change', '.barang', function() {
            var selectedOption = $(this).find('option:selected');
            var satuan = selectedOption.data('satuan');

            $('.showSatuan').val(satuan || '');
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
                window.location.href = url;
            }
        });
    }

    function confirmSubmit(event, formId) {
        event.preventDefault();

        const form = document.getElementById(formId);
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
            Swal.fire({
                title: 'Submit',
                text: '',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
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
