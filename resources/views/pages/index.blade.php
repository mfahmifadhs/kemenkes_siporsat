@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-weight-bold mb-4 text-capitalize">
                            Selamat Datang, {{ ucfirst(strtolower(Auth::user()->pegawai->nama_pegawai)) }}
                        </h4>
                    </div>

                    <div class="col-md-3">
                        <div class="card border border-dark">
                            <div class="card-body">
                                <label>Verifikasi Email</label>
                                @if (!Auth::user()->email)
                                <p class="text-xs">Anda belum melakukan verifikasi email</p>
                                <a href="{{ route('email') }}" class="btn btn-danger btn-xs"><i class="fas fa-exclamation-circle"></i> Tidak Terdaftar</a>
                                @else
                                <p class="text-xs">Anda sudah melakukan verifikasi email</p>
                                <a href="{{ route('email') }}" class="btn btn-success btn-xs"><i class="fas fa-check-circle"></i> Terdaftar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- Total Barang -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box border border-dark">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-box"></i></span>
                                    <div class="info-box-content">
                                        <span class="p-0" style="margin-top: 0%;">Total Usulan
                                            <h6 class="text-xs">Kerumahtanggaan</h6>
                                        </span>
                                        <span class="info-box-number">
                                            {{ $usulan->where('form_id', 1)->count() }}
                                            <small>usulan</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box border border-dark">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-signature"></i></span>
                                    <div class="info-box-content">
                                        <span class="p-0" style="margin-top: 0%;">Total Usulan
                                            <h6 class="text-xs">Gedung Bangunan</h6>
                                        </span>
                                        <span class="info-box-number">
                                            {{ $usulan->where('form_id', 2)->count() }}
                                            <small>usulan</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box border border-dark">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-pencil"></i></span>
                                    <div class="info-box-content">
                                        <span class="p-0" style="margin-top: 0%;">Total Usulan
                                            <h6 class="text-xs">Alat Tulis Kantor</h6>
                                        </span>
                                        <span class="info-box-number">
                                            {{ $usulan->where('form_id', 3)->count() }}
                                            <small>usulan</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Usulan -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2 border border-dark">
                                    <div class="bg-primary p-3">
                                        <h6 class="my-auto font-weight-bold">
                                            <i class="fas fa-people-roof"></i> Usulan Kerumahtanggaan
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column font-weight-bold">
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'ukt') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="verif">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-file-signature"></i> Persetujuan
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 1)->whereNull('status_persetujuan')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'ukt') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="proses">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-clock"></i> Proses
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 1)->where('status_proses', 'proses')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'ukt') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="selesai">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 1)->where('status_proses', 'selesai')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'ukt') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="false">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 1)->where('status_persetujuan', 'false')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2 border border-dark">
                                    <div class="bg-primary p-3">
                                        <h6 class="my-auto font-weight-bold">
                                            <i class="fas fa-city"></i> Usulan Gedung Bangunan
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column font-weight-bold">
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'gdn') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="verif">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-file-signature"></i> Persetujuan
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 2)->whereNull('status_persetujuan')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'gdn') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="proses">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-clock"></i> Proses
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 2)->where('status_proses', 'proses')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'gdn') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="selesai">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 2)->where('status_proses', 'selesai')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'gdn') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="false">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 2)->where('status_persetujuan', 'false')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2 border border-dark">
                                    <div class="bg-primary p-3">
                                        <h6 class="my-auto font-weight-bold">
                                            <i class="fas fa-pencil-ruler"></i> Usulan ATK
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column font-weight-bold">
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="verif">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-file-signature"></i> Persetujuan
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->whereNull('status_persetujuan')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="proses">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-clock"></i> Proses
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_proses', 'proses')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="selesai">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_proses', 'selesai')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="proses" value="false">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_persetujuan', 'false')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card border border-dark" style="height: 93%;">
                                    <div class="card-body text-center">
                                        <canvas id="stokChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('stokChart').getContext('2d');

        // Ambil data dari Laravel (pastikan tidak kosong)
        var usulanUkt = Number("{{ $usulan->where('form_id', 1)->count() ?? 0 }}");
        var usulanGdn = Number("{{ $usulan->where('form_id', 2)->count() ?? 0 }}");
        var usulanAtk = Number("{{ $usulan->where('form_id', 3)->count() ?? 0 }}");

        // Pastikan plugin datalabels terdaftar
        Chart.plugins.register(ChartDataLabels);

        var stokChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Usulan UKT', 'Usulan GDN', 'Usulan ATK'],
                datasets: [{
                    data: [usulanUkt, usulanGdn, usulanAtk], // Data angka
                    backgroundColor: ['#4CAF50', '#FF5733']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'right'
                },
                plugins: {
                    datalabels: {
                        color: '#fff', // Warna teks angka
                        anchor: 'center',
                        align: 'center',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return value.toLocaleString(); // Format angka dengan pemisah ribuan
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    $(function() {
        var currentdate = new Date();
        var datetime = "Tanggal: " + currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear() + " \n Pukul: " +
            currentdate.getHours() + ":" +
            currentdate.getMinutes() + ":" +
            currentdate.getSeconds()


        $("#table-data").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'pdf',
                text: ' PDF',
                pageSize: 'A4',
                className: 'bg-danger btn-sm',
                title: 'show'
            }, {
                extend: 'excel',
                text: ' Excel',
                className: 'bg-success btn-sm',
                title: 'show'
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
    })
</script>
@endsection
@endsection
