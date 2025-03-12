@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Usulan Alat Tulis Kantor</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('usulan','atk') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $usulan->whereNull('status_persetujuan')->count() }}<small>usulan</small></h3>
                                <p>MENUNGGU PERSETUJUAN</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="text-center p-2 border border-top">
                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="proses" value="verif">
                                    <button class="btn btn-default btn-xs border-secondary">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $usulan->where('status_proses', 'proses')->count() }}<small>usulan</small></h3>
                                <p>SEDANG DIPROSES</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="text-center p-2 border border-top">
                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="proses" value="proses">
                                    <button class="btn btn-default btn-xs border-secondary">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $usulan->where('status_proses', 'selesai')->count() }}<small>usulan</small></h3>
                                <p>SELESAI BERITA ACARA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="text-center p-2 border border-top">
                                <form action="" method="GET">
                                    @csrf
                                    <input type="hidden" name="status" value="106">
                                    <button class="btn btn-default btn-xs border-secondary">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $usulan->where('status_persetujuan', 'false')->count() }}<small>usulan</small></h3>
                                <p>PENGAJUAN DITOLAK</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="text-center p-2 border border-top">
                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="proses" value="false">
                                    <button class="btn btn-default btn-xs border-secondary">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <label>Daftar Barang</label>
                <div class="form-group row">
                    <div class="col-md-3 form-group">
                        <select name="" class="form-control" id="kategori">
                            <option value="">Seluruh Barang</option>
                            @foreach ($kategori as $row)
                            <option value="{{ $row->id_kategori }}">{{ $row->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 form-group">
                        <div class="input-with-icon">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Barang..." onkeyup="search()">
                            <a href="javascript:void(0);" onclick="clearSearch()"><i class="fa fa-times fa-sm text-black"></i></a>
                        </div>
                    </div>
                    <div class="col-md-1 form-group">
                        <a type="button" class="btn btn-app btn-default btn-block border-dark" data-toggle="modal" data-target="#basket">
                            <span class="badge bg-danger mr-3" id="cart-count">{{ Auth::user()->keranjang->count() }}</span>
                            <i class="fas fa-basket-shopping text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="form-group row" id="cardContainer">
                    @foreach ($atk as $row)
                    <div class="form-group col-md-2 col-6" data-kategori="{{ $row->kategori_id }}">
                        <div class="card card-psdia">
                            <div class="card-header">
                                @if ($row->foto_barang)
                                <img src="{{ asset('dist/img/foto_barang/'. $row->foto_barang) }}" class="img-fluid" alt="">
                                @else
                                <img src="https://cdn-icons-png.flaticon.com/512/679/679821.png" class="img-fluid" alt="">
                                @endif
                            </div>
                            <div class="card-body">

                                <h5>{{ $row->kategori->nama_kategori }}</h5>
                                <h4 class="hide-text-p2">{{ $row->nama_barang }}</h4>
                                <h6 class="text-secondary">{{ $row->deskripsi ? $row->deskripsi : $row->satuan->nama_satuan }}</h6>
                            </div>
                            <div class="card-footer">
                                <form id="form-{{ $row->id_atk }}" action="{{ route('atk-bucket.create') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="atk_id" value="{{ $row->id_atk }}">
                                    <input type="hidden" name="proses" value="keranjang">
                                    <div class="input-group">
                                        <a type="button" class="min-button" data-id="data-{{ $row->id_atk }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text rounded-left border-dark" style="height: 31px;">
                                                    -
                                                </div>
                                            </div>
                                        </a>
                                        <input type="hidden" class="form-control">
                                        <input type="text" class="form-control form-control-sm text-center bg-white number" id="data-{{ $row->id_atk }}" name="qty" value="0" min="1" @if(Auth::user()->role_id == 4) max="{{ $row->jumlah_maks }}" @endif>

                                        <a type="button" class="add-button" data-id="data-{{ $row->id_atk }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text border-dark" style="height: 31px;">
                                                    +
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <button class="btn btn-outline-danger btn-block btn-sm add-to-cart-button mt-2 {{ $row->status != 'true' ? 'disabled' : '' }}" data-id="{{ $row->id_atk }}">
                                        <i class="fas fa-plus"></i> Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12 d-none" id="notif">
                        <span class="text-center">Data tidak ditemukan...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form id="form" action="{{ route('usulan.store', 'atk') }}" method="POST">
    @csrf
    <div class="modal fade" id="basket" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <input type="hidden" name="form_id" value="3">
                <div class="modal-header border-dark">
                    <h5 class="modal-title text-md">KERANJANG SAYA (<span id="cart-count-in">{{ Auth::user()->keranjang->count() }}</span> item)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <div class="form-group">
                        <div class="row">
                            @if (Auth::user()->role_id == 4)
                            <div class="col-md-6 text-sm mt-2">
                                <div class="d-flex">
                                    <label class="w-25">Tanggal</label>
                                    <span class="w-75">: {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</span>
                                </div>
                                <div class="d-flex">
                                    <label class="w-25">Usulan</label>
                                    <span class="w-75">: Permintaan ATK</span>
                                </div>
                                <div class="d-flex">
                                    <label class="w-25">Unit Kerja</label>
                                    <span class="w-75">:
                                        {{ ucwords(strtolower(Auth::user()->pegawai->uker->unit_kerja)) }} |
                                        {{ ucwords(strtolower(Auth::user()->pegawai->uker->utama->unit_utama)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-sm">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required></textarea>
                                </div>
                            </div>
                            @endif

                            @if (Auth::user()->akses_id == 3)
                            <input type="hidden" name="cito" value="true">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-sm">Tanggal</label>
                                    <input type="date" class="form-control mb-1" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">

                                    <label class="text-sm">Pilih Pengusul</label>
                                    <select class="form-control pengusul" name="pengusul" style="width: 100%;">
                                        <option value="">-- Cari Pengusul --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-sm">Nama Penerima</label>
                                    <input type="text" class="form-control mb-1" name="penerima">

                                    <label class="text-sm">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <table class="table table-bordered text-center text-sm m-1">

                    </table>

                    <div id="cart-items">
                        @foreach (Auth::user()->keranjang as $row)
                        <input type="hidden" name="id_keranjang[]" value="{{ $row->id_keranjang }}">
                        <input type="hidden" name="id_atk[]" value="{{ $row->atk_id }}">
                        <table class="table table-bordered text-center text-sm m-1">
                            @php $totalRow = 0; @endphp
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 5%;" class="p-2">Foto</th>
                                    <th>Barang</th>
                                    <th style="width: 15%;">Jumlah</th>
                                    <th style="width: 10%;">Satuan</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        @php $totalRow++; @endphp
                                        <a href="#" onclick="confirmRemove(<?php echo $row->id_keranjang; ?>)">
                                            <i class="fas fa-minus-circle fa-1x text-danger"></i>
                                        </a>
                                        {{ $loop->iteration }}

                                    </td>
                                    <td class="align-middle">
                                        @if ($row->atk->foto_barang)
                                        <img src="{{ asset('dist/img/foto_snaco/'. $row->atk->foto_barang) }}" class="img-fluid" alt="">
                                        @else
                                        <img src="https://cdn-icons-png.flaticon.com/512/679/679821.png" class="img-fluid" alt="">
                                        @endif
                                    </td>
                                    <td class="align-middle text-left">
                                        {{ $row->atk->kategori->nama_kategori }}
                                        {{ $row->atk->nama_barang }} {{ $row->atk->deskripsi }}
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="input-group-text rounded-left" style="height: 31px;">
                                                    <a type="button" class="qty-button-modal col-12" data-id="{{ $row->id_keranjang }}" href="{{ route('atk-bucket.update', ['aksi' => 'plus', 'id' => $row->id_keranjang]) }}">
                                                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <input type="text" class="form-control form-control-sm text-center bg-white col-12" id="{{ $row->id_keranjang }}" name="jumlah[]" value="{{ $row->jumlah }}" min="1" readonly>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="input-group-text rounded-left" style="height: 31px;">
                                                    <a type="button" class="qty-button-modal col-12" data-id="{{ $row->id_keranjang }}" href="{{ route('atk-bucket.update', ['aksi' => 'min', 'id' => $row->id_keranjang]) }}">
                                                        <i class="fas fa-minus-circle" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><label>{{ $row->atk->satuan->nama_satuan }}</label></td>
                                    <td class="text-left">
                                        <input type="text" id="keteranganInput-{{ $row->id_keranjang }}" name="keterangan_permintaan[]" class="form-control form-control-sm" placeholder="Keterangan">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endforeach
                        @if(Auth::user()->keranjang->count() == 0)
                        <table class="table table-bordered text-center text-sm m-1">
                            <tr>
                                <td colspan="6">Data tidak ditemukan</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-dark">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-paper-plane"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    // table
    $("#table-basket").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": false,
        "paging": true,
        "searching": false
    })

    // alert
    $(document).ready(function() {
        $(".add-to-cart-button").click(function(event) {
            event.preventDefault(); // Mencegah tindakan default dari tombol

            const formId = $(this).data("id");
            const form = $("#form-" + formId);

            const qty = parseFloat(form.find('input[name="qty"]').val().replace(/\./g, '')) || 0
            const maxQty = form.find('input[name="qty"]').attr("max")

            console.log('maks ' + qty)

            if (qty == 0) {
                Swal.fire({
                    title: 'Jumlah harus lebih dari 1',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000
                });
            } else {
                if (qty >= maxQty) {
                    Swal.fire({
                        title: 'Melebihi batas permintaan',
                        text: '',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    location.reload();
                } else {
                    $.ajax({
                        url: form.attr("action"),
                        type: form.attr("method"),
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: 'Proses...',
                                text: 'Mohon menunggu.',
                                icon: 'info',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            Swal.fire({
                                title: 'Berhasil Tambah Keranjang',
                                text: '',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            });

                            form.find('input[name="qty"]').val(0);
                            // Perbarui jumlah item di keranjang
                            $("#cart-count").text(response.cartCount);
                            $("#cart-count-in").text(response.cartCount);
                            $("#cart-items").empty();

                            // Update the cart items
                            updateCartItems(response.cartBasket);
                            location.reload();
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Gagal Menambah Keranjang',
                                text: error.responseText,
                                icon: 'error',
                            });
                        }
                    });
                }
            }
        });

        // BTN PLUS MIN
        $(".add-button").click(function(event) {
            event.preventDefault();
            const dataId = $(this).data("id");
            const inputElement = $("#" + dataId);
            let currentValue = parseInt(inputElement.val());
            currentValue++; // Menambah nilai

            inputElement.val(currentValue);
        });

        $(".min-button").click(function(event) {
            event.preventDefault();
            const dataId = $(this).data("id");
            const inputElement = $("#" + dataId);
            let currentValue = parseInt(inputElement.val());

            if (currentValue > 0) { // Periksa agar tidak kurang dari 1
                currentValue--; // Mengurangkan nilai
            }

            inputElement.val(currentValue);
        });

        $(".qty-button-modal").click(function(event) {
            event.preventDefault();
            const dataId = $(this).data("id");
            const link = $(this).attr('href');
            const inputElement = $("#" + dataId);

            $.ajax({
                url: link,
                type: "GET",
                success: function(response) {
                    const updatedKuantitas = response.updatedKuantitas.jumlah;
                    inputElement.val(updatedKuantitas);
                }
            })
        })

        // format angka
        $('.number').on('input', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');

            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            $(this).val(formattedValue);
        });
    });

    function updateCartItems(cartBasket) {
        $("#cart-items").empty();

        $.each(cartBasket, function(index, item) {
            const updateMin = '{{ route("atk-bucket.update", ["aksi" => "min", "id" => "__ID__"]) }}'.replace('__ID__', item.id_keranjang)
            const updateAdd = '{{ route("atk-bucket.update", ["aksi" => "add", "id" => "__ID__"]) }}'.replace('__ID__', item.id_keranjang)
            const removeItem = '{{ route("atk-bucket.remove", ["id" => "__ID__"]) }}'.replace('__ID__', item.id_keranjang)
            const satuan = ''

            const cartItem = `
                <table class="table table-bordered text-center text-sm m-1">
                    @php $totalRow = 0; @endphp
                    <input type="hidden" name="id_keranjang[]" value="${item.id_keranjang}">
                    <input type="hidden" name="id_atk[]" value="${item.atk_id}">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 5%;" class="p-2">Foto</th>
                            <th>Barang</th>
                            <th style="width: 15%;">Jumlah</th>
                            <th style="width: 10%;">Satuan</th>
                            <th style="width: 30%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                @php $totalRow++; @endphp
                                <a href="#" onclick="confirmRemove(${item.id_keranjang})">
                                    <i class="fas fa-minus-circle fa-1x text-danger"></i>
                                </a>
                                ${index + 1}
                            </td>
                            <td class="align-middle">
                                <img src="${item.foto_barang ? '/storage/files/foto_barang/' + item.foto_barang : 'https://cdn-icons-png.flaticon.com/512/679/679821.png'}" class="img-fluid img-size-50 mr-3" alt="">
                            </td>
                            <td class="align-middle">
                                ${ item.nama_kategori }
                                ${ item.nama_barang } ${ item.deskripsi }
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group-text rounded-left" style="height: 31px;">
                                            <a type="button" class="qty-button-modal col-12" data-id="${item.id_keranjang}" href="${updateAdd}">
                                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <input type="text" class="form-control form-control-sm text-center bg-white col-12" id="${item.id_keranjang}" name="jumlah[]" value="${item.jumlah}" min="1" readonly>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="input-group-text rounded-left" style="height: 31px;">
                                            <a type="button" class="qty-button-modal col-12" data-id="${item.id_keranjang}" href="${updateMin}">
                                                <i class="fas fa-minus-circle" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td>${ item.nama_satuan }</td>
                            <td class="text-left">
                                <input type="text" id="keteranganInput-{{ $row->id_keranjang }}" name="keterangan_permintaan[]" class="form-control form-control-sm" placeholder="Keterangan">
                            </td>
                        </tr>
                    </tbody>
                </table>
                `;
            $("#cart-items").append(cartItem);
        });

        $(".qty-button-modal").click(function(event) {
            event.preventDefault(); // Mencegah tindakan default dari tombol
            const dataId = $(this).data("id");
            const link = $(this).attr('href');
            const inputElement = $("#" + dataId);

            $.ajax({
                url: link,
                type: "GET",
                success: function(response) {
                    const updatedKuantitas = response.updatedKuantitas.jumlah;
                    inputElement.val(updatedKuantitas);
                }
            })
        })
    }

    // pencarian barang
    function search() {
        var input, filter, cards, cardContainer, description, i;
        var notif = document.getElementById("notif");
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        cardContainer = document.getElementById("cardContainer");
        cards = cardContainer.getElementsByClassName("col-md-2");


        // Sembunyikan notifikasi "Data tidak ditemukan" secara default
        notif.classList.add("d-none");

        var found = false; // Inisialisasi found sebagai false

        for (i = 0; i < cards.length; i++) {
            description = cards[i].querySelector(".hide-text-p2").innerText.toLowerCase();
            console.log(description)

            if (description.indexOf(filter) > -1) {
                cards[i].style.display = "";
                found = true; // Set found menjadi true jika ada deskripsi yang cocok
            } else {
                cards[i].style.display = "none";
            }
        }

        // Setel notifikasi "Data tidak ditemukan" jika tidak ada deskripsi yang cocok
        if (!found) {
            notif.classList.remove("d-none");
        }
    }

    // Trigger search function when typing in search input
    document.getElementById("searchInput").addEventListener("keyup", search);

    // filter berdasarkan kategori
    document.addEventListener("DOMContentLoaded", function() {
        // Select element
        var kategoriSelect = document.getElementById("kategori");
        var cardContainer = document.getElementById("cardContainer");
        var notif = document.getElementById("notif");

        // Event listener untuk meng-handle perubahan pada dropdown kategori
        kategoriSelect.addEventListener("change", function() {
            // Mendapatkan nilai kategori yang dipilih
            var selectedKategori = this.value.toLowerCase();
            var found = false;

            // Loop melalui semua kartu ATK
            var cards = cardContainer.getElementsByClassName("form-group col-md-2");
            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                var cardKategori = card.getAttribute("data-kategori").toLowerCase();

                // Memeriksa apakah kartu harus ditampilkan atau disembunyikan berdasarkan kategori yang dipilih
                if (selectedKategori === "" || cardKategori === selectedKategori) {
                    card.style.display = "block";
                    found = true
                } else {
                    card.style.display = "none";
                }

                if (!found) {
                    notif.classList.remove("d-none");
                } else {
                    notif.classList.add("d-none");
                }
            }
        });
    });

    // Hapus nilai pencarian
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchForm').submit();
    }

    // HAPUS BARANG KERANJANG
    function confirmRemove(itemId) {
        Swal.fire({
            title: 'Hapus Item ?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to delete the item
                $.ajax({
                    type: 'GET',
                    url: '{{ route("atk-bucket.remove", ["id" => "__ID__"]) }}'.replace('__ID__', itemId),
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: 'Barang telah dihapus!',
                            text: '',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#cart-count").text(response.cartCount);
                        $("#cart-count-in").text(response.cartCount);
                        $("#cart-items").empty();

                        // Update the cart items
                        updateCartItems(response.cartBasket);
                        location.reload();
                    },
                    error: function(error) {
                        // Show error message
                        Swal.fire({
                            title: 'Error deleting item',
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }
        });
    }

    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');
        const requiredInputs = form.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)');
        const basket = '{{ Auth::user()->keranjang->count() }}'

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

            if (basket == 0) {
                Swal.fire({
                    title: 'Error',
                    text: 'Tidak ada barang yang ditemukan',
                    icon: 'error'
                });
            } else {
                Swal.fire({
                    title: 'Tambah',
                    text: '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, tambah!',
                    cancelButtonText: 'Batal!',
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

<script>
    $(document).ready(function() {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        $(".pengusul").select2({
            placeholder: "Cari Pengusul...",
            allowClear: true,
            ajax: {
                url: "{{ route('users.select') }}",
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

        $(".pengusul").each(function() {
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
