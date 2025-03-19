@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container col-md-9">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Proses Usulan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan', $form) }}">Daftar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan.detail', $data->id_usulan) }}">Detail</a></li>
                    <li class="breadcrumb-item active">Proses</li>
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
                    Proses Usulan
                </label>
                <div class="card-tools">
                    <div class="input-group">
                        <div class="form-group ml-1">
                            <form id="form-submit" action="{{ route('usulan.proses', $data->id_usulan) }}" method="GET">
                                @csrf
                                <input type="hidden" name="proses" value="selesai">
                                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
                                <input type="hidden" name="penerima" id="penerima">

                                <button type="submit" class="btn btn-warning border-dark btn-sm mt-2" onclick="confirmOtp(event)">
                                    <i class="fas fa-file-import"></i> Proses
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
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
            </div>
            <div class="card-body small">
                <div class="d-flex">
                    <div class="w-50 text-left">
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
                        @if ($data->form_id == 5)
                        <div class="input-group">
                            <label class="w-25">Bulan Permintaan</label>
                            <span class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('MMMM Y') }}</span>
                        </div>
                        @endif
                        @if ($data->status_persetujuan == 'true')
                        <div class="input-group">
                            <label class="w-25">Surat Usulan</label>
                            <span class="w-75">:
                                <a href="{{ route('usulan.surat', $data->id_usulan) }}" target="_blank">
                                    <u><i class="fas fa-file-alt"></i> Lihat Surat</u>
                                </a>
                            </span>
                        </div>
                        @endif
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
                    @if ($data->form_id == 3)
                    <div class="col-md-4">
                        @if (!$data->tanggal_ambil)
                        <div class="input-group">
                            <label class="w-50">Tanggal Terima</label>
                            <span class="w-50">: {{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('DD MMMM Y') }}</span>
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
                    @endif
                </div>
            </div>
            <!-- ========================= UKT & GDN ============================ -->
            @if (in_array($data->form_id, [1,2]))
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pekerjaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Uraian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detail as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->gdn ? $row->gdn->nama_perbaikan .',' : '' }} {!! nl2br($row->judul) !!}</td>
                                <td>{!! nl2br($row->uraian) !!}</td>
                                <td>{!! nl2br($row->keterangan) !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== ATK ================================= -->
            @if ($data->form_id == 3)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Permintaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->detailAtk as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->atk->nama_barang }}</td>
                                <td>{{ $row->atk->deskripsi }}</td>
                                <td class="text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== AADB SERVIS ================================= -->
            @if ($data->form_id == 4)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pemeliharaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Kendaraan</th>
                                <th>Uraian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detailServis as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->aadb->no_polisi ? $row->aadb->no_polisi .' - ' : '' }} {{ $row->aadb->merk_tipe }}</td>
                                <td>{!! nl2br($row->uraian) !!}</td>
                                <td>{!! nl2br($row->keterangan)  !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== AADB BBM ================================= -->
            @if ($data->form_id == 5)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pemeliharaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>No. Polisi</th>
                                <th>Kendaraan</th>
                                <th>Merk/Tipe</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detailBbm as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->aadb->no_polisi }}</td>
                                <td>{{ $row->aadb->kategori->nama_kategori }}</td>
                                <td>{{ $row->aadb->merk_tipe }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

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
                url: '/snaco/detail/barang/' + kategoriId,
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

            $('#satuan').val(satuan || '');
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

    function confirmTrue(event) {
        event.preventDefault();

        const form = document.getElementById('form-submit');

        Swal.fire({
            title: 'Konfirmasi Penyerahan',
            text: 'Apakah Anda yakin selesai menyerahkan permintaan ini?',
            icon: 'warning',
            input: 'text',
            inputPlaceholder: 'Pilih Tanggal Penyerahan',
            inputAttributes: {
                'aria-label': 'Pilih tanggal penyerahan di sini',
                'readonly': true
            },
            customClass: {
                input: 'text-center'
            },
            showCancelButton: true,
            confirmButtonText: 'Proses',
            cancelButtonText: 'Batal',
            didOpen: () => {
                flatpickr(Swal.getInput(), {
                    dateFormat: "Y-m-d"
                });
            },
        }).then((result) => {
            const selectedDate = result.value;
            if (result.isConfirmed && selectedDate) {
                Swal.fire({
                    title: 'Penyerahan',
                    text: 'Usulan telah diserahkan pada tanggal: ' + selectedDate,
                    icon: 'success'
                });

                document.getElementById('tanggal_selesai').value = selectedDate;
                form.submit();
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Belum memilih tanggal ',
                    icon: 'error'
                });
            }
        });
    }

    function confirmOtp(event) {
        event.preventDefault();

        const form = document.getElementById('form-submit');

        Swal.fire({
            title: 'Konfirmasi Serah Terima',
            text: 'Masukkan Kode OTP yang diterima oleh Unit Kerja',
            icon: 'warning',
            html: `
                <input type="date" id="input2" class="swal2-input w-75 border border-dark text-center" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="Enter second value">
                <input type="text" id="input3" class="swal2-input w-75 border border-dark text-center" placeholder="Nama Penerima">
            `,
            customClass: {
                input: 'text-center',

            },
            preConfirm: () => {
                const tanggal = document.getElementById('input2').value;
                const penerima = document.getElementById('input3').value;

                // Jika belum ada tanggal yang dipilih, set default text
                if (!tanggal) {
                    document.getElementById('input2').setAttribute('placeholder', 'Tanggal belum dipilih');
                }

                if (!tanggal || !penerima) {
                    Swal.showValidationMessage('Harap isi semua input!');
                    return false;
                }

                return {
                    tanggal: tanggal,
                    penerima: penerima
                };
            },
            showCancelButton: true,
            confirmButtonText: 'Proses',
            cancelButtonText: 'Batal'
        }).then((result) => {
            const selectedDate = result.value.tanggal;
            const penerima = result.value.penerima;

            if (result.isConfirmed) {
                if (!selectedDate) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Belum memilih tanggal ',
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'Penyerahan',
                        text: 'Usulan telah diserahkan pada tanggal: ' + selectedDate,
                        icon: 'success'
                    });

                    document.getElementById('tanggal_selesai').value = selectedDate;
                    document.getElementById('penerima').value = penerima;
                    form.submit();
                }
            }
        });
    }
</script>
@endsection

@endsection
