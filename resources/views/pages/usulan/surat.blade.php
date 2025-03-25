<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPORSAT KEMENKES RI</title>

    <!-- Icon Title -->
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">

    <style>
        body {
            font-family: Arial;
        }

        @media print {

            .table-container {
                page-break-before: auto;
                page-break-inside: auto;
            }

            .footer-container {
                page-break-inside: avoid;
            }

            .footer-container .row {
                page-break-inside: avoid;
            }

            .footer-container h3,
            .footer-container img {
                page-break-inside: avoid;
            }

            table {
                page-break-before: auto;
                page-break-inside: auto;
                border-collapse: collapse;
                width: 100%;
            }

            thead {
                display: table-header-group;
                border: 2px solid;
            }

            tbody {
                display: table-row-group;
                border: 2px solid;
            }

            tr {
                page-break-inside: auto;
                border: 2px solid;
            }

            thead .th {
                border: 2px solid !important;
            }

            tbody .td {
                border: 2px solid !important;
            }
        }
    </style>
</head>

<body>
    <div class="card mx-5">
        <div class="card-body">
            <img src="{{ asset('dist/img/header-'.$data->pegawai->uker->utama_id.'.png') }}" alt="">
        </div>
        <div class="card-body no-break">
            <div class="text-center text-uppercase">
                <h3><b>{{ $data->form_id == 3 ? 'Berita Acara Serah Terima' : 'Surat Usulan' }}</b></h3>
                <h4>Nomor : {{ $data->nomor_usulan }}</h4>
            </div>
        </div>
        <div class="card-body h3 no-break">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col-3">Hal</div>
                        <div class="col-8">: {{ $data->form->nama_form }}</div>
                    </div>
                </div>
                <div class="col-4">
                    {{ Carbon\Carbon::parse($data->tanggal_usulan)->isoFormat('DD MMMM Y') }}
                </div>
            </div>
            <div class="row mt-3 ls-base">
                <div class="col-2">Nama</div>
                <div class="col-9">: {{ $data->pegawai->nama_pegawai }}</div>
                <div class="col-2">Jabatan</div>
                <div class="col-9">: {{ $data->pegawai->jabatan->jabatan }} {{ $data->pegawai->tim_kerja }}</div>
                <div class="col-2">Unit Kerja</div>
                <div class="col-9">: {{ $data->pegawai->uker->unit_kerja }} | {{ $data->pegawai->uker->utama->unit_utama }}</div>
            </div>
        </div>
        <!-- ========================= UKT & GDN ============================ -->
        @if (in_array($data->form_id, [1,2]))
        <div class="card-body">
            <div class="table-container">
                <table class="table table-bordered border border-dark">
                    <thead class="h4 text-center">
                        <tr>
                            <th class="th" style="width: 5%;">No</th>
                            <th class="th" style="width: 30%;">Judul</th>
                            <th class="th">Uraian</th>
                            <th class="th" style="width: 20%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="h4">
                        @foreach ($data->detail as $row)
                        <tr class="bg-white">
                            <td class="text-center td">{{ $loop->iteration }}</td>
                            <td class="td">{{ $row->gdn ? $row->gdn->nama_perbaikan .',' : '' }} {!! $row->judul !!}</td>
                            <td class="td">{!! nl2br($row->uraian) !!}</td>
                            <td class="td">{!! nl2br($row->keterangan) !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- ========================== ATK ================================= -->
        @if ($data->form_id == 3)
        <div class="card-body h4" style="overflow-y: auto; max-height: 50vh;">
            <label>Uraian Permintaan</label>
            <div class="table-responsive">
                <table id="table" class="table table-bordered border border-dark h4">
                    <thead class="text-center">
                        <tr>
                            <th class="th">No</th>
                            <th class="th">Nama Barang</th>
                            <th class="th">Deskripsi</th>
                            <th class="th">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->detailAtk as $row)
                        <tr class="bg-white">
                            <td class="td text-center">{{ $loop->iteration }}</td>
                            <td class="td">{{ $row->atk->nama_barang }}</td>
                            <td class="td">{{ $row->atk->deskripsi }}</td>
                            <td class="td text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- ========================== AADB SERVIS ================================= -->
        @if ($data->form_id == 4)
        <div class="card-body h4" style="overflow-y: auto; max-height: 50vh;">
            <label>Uraian Pemeliharaan</label>
            <div class="table-responsive">
                <table id="table" class="table table-bordered border border-dark h4">
                    <thead class="text-center">
                        <tr>
                            <th class="th">No</th>
                            <th class="th">Nama Kendaraan</th>
                            <th class="th">Uraian</th>
                            <th class="th">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->detailServis as $row)
                        <tr class="bg-white">
                            <td class="td text-center">{{ $loop->iteration }}</td>
                            <td class="td">{{ $row->aadb->no_polisi ? $row->aadb->no_polisi .' - ' : '' }} {{ $row->aadb->merk_tipe }}</td>
                            <td class="td">{!! nl2br($row->uraian) !!}</td>
                            <td class="td">{!! nl2br($row->keterangan) !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- ========================== AADB BBM ================================= -->
        @if ($data->form_id == 5)
        <div class="card-body h4" style="overflow-y: auto; max-height: 50vh;">
            <label>Uraian Permintaan BBM <u>{{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('MMMM Y') }}</u></label>
            <div class="table-responsive">
                <table id="table" class="table table-bordered border border-dark h4">
                    <thead class="text-center">
                        <tr>
                            <th class="th">No</th>
                            <th class="th">No. Polisi</th>
                            <th class="th">Kendaraan</th>
                            <th class="th">Merk/Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->detailBbm as $row)
                        <tr class="bg-white">
                            <td class="td text-center">{{ $loop->iteration }}</td>
                            <td class="td">{{ $row->aadb->no_polisi }}</td>
                            <td class="td">{{ $row->aadb->kategori->nama_kategori }}</td>
                            <td class="td">{{ $row->aadb->merk_tipe }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="card-body">
            <div class="footer-container">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <h3 class="lh-base">
                            Demikian {{ $data->form_id == 3 ? 'berita acara serah terima' : 'surat usulan' }}
                            ini kami sampaikan. Atas perhatian dan kerjasamanya diucapkan terima kasih
                        </h3>
                    </div>
                    @if ($data->status_persetujuan == 'true')
                    <div class="col-5">
                        <h3>Disetujui oleh,</h3>
                        <h3>{{ $data->verif->jabatan->jabatan }} {{ $data->verif->tim_kerja }}</h3>
                        <h3 class="my-3"><img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_2 .'/'. $data->kode_usulan) }}" width="150" alt="QR Code"></h3>
                        <h3>{{ $data->verif->nama_pegawai }}</h3>
                    </div>
                    @else
                    <div class="col-5"></div>
                    @endif
                    <div class="col-2"></div>
                    <div class="col-5">
                        <h3>Diusulkan oleh,</h3>
                        <h3>{{ $data->pegawai->jabatan->jabatan }} {{ $data->pegawai->tim_kerja }}</h3>
                        <h3 class="my-3"><img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_1 .'/'. $data->kode_usulan) }}" width="150" alt="QR Code"></h3>
                        <h3>{{ $data->pegawai->nama_pegawai }}</h3>
                    </div>
                </div>
                @if ($data->form_id == 3)
                <div class="row mt-5">
                    <div class="col-md-12">
                        <h3 class="lh-base">
                            {{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('DD MMMM Y') }}
                        </h3>
                    </div>
                    @if ($data->nama_penerima)
                    <div class="col-5">
                        <h3>Diserahkan oleh,</h3>
                        <h3>{{ $data->form_id == 3 ? 'Petugas Gudang' : $data->verif->jabatan->jabatan.' '.$data->verif->tim_kerja }}</h3>
                        <h3 class="my-3"><img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_4 .'/'. $data->kode_usulan) }}" width="150" alt="QR Code"></h3>
                        <h3>{{ $data->form_id == 3 ? 'Nando' : 'Staf' }}</h3>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <h3>Diterima oleh,</h3>
                        <h3>{{ $data->pegawai->uker->unit_kerja }}</h3>
                        <h3 class="my-3"><img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_3 .'/'. $data->kode_usulan) }}" width="150" alt="QR Code"></h3>
                        <h3>{{ $data->nama_penerima }}</h3>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

    </div>
</body>

<script>
    window.addEventListener("load", window.print());
</script>

</html>
