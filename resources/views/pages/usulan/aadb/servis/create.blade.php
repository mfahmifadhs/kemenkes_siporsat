@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-10">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Tambah Usulan</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('usulan','aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-10">
        <div class="card border border-dark">
            <form id="form" action="{{ route('usulan.store', 'servis') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header font-weight-bold mt-2">
                    Tambah Usulan Pemeliharaan AADB
                    <h6 class="text-muted small">
                        Pekerjaan yang berkaitan dengan Pemeliharaan AADB
                    </h6>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 60vh;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <label class="w-25 col-form-label">Kendaraan</label>
                                <span class="w-75 input-group">
                                    <select name="aadb[]" class="form-control rounded aadb" required>
                                        <option value="">-- Pilih Kendaraan --</option>
                                        @foreach($aadb as $row)
                                        <option value="{{ $row->id_aadb }}">
                                            {{ $row->no_polisi && $row->no_polisi != '-' ? $row->no_polisi.' - '.$row->merk_tipe : $row->merk_tipe }}
                                        </option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>

                            <div class="input-group mt-2">
                                <label class="w-25 col-form-label">Uraian</label>
                                <span class="w-75 input-group">
                                    <textarea name="uraian[]" class="form-control rounded" rows="8" placeholder="Contoh : Uraian Perbaikan Kendaraan" required></textarea>
                                </span>
                            </div>

                            <div class="input-group mt-2">
                                <label class="w-25 col-form-label">Keterangan</label>
                                <span class="w-75 input-group">
                                    <textarea class="form-control rounded" name="keterangan[]" rows="2" placeholder="Keterangan Tambahan"></textarea>
                                </span>
                            </div>

                            <div class="input-group mt-3">
                                <label class="w-25 col-form-label">Data Pendukung</label>
                                <span class="w-75 input-group">
                                    <div class="btn btn-default btn-file w-75 border border-dark p-2">
                                        <i class="fas fa-upload"></i> Upload PDF <br>
                                        <small>Data Pendukung Foto Kerusakan/Lainnya dalam 1 file PDF (maks. 2mb)</small> <br>
                                        <input type="file" class="form-control image" name="file" onchange="displaySelectedFile(this)" accept=".pdf" required>
                                        <span id="selected-file-name"></span>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
                    </button>
                </div>
            </form>
        </div>


    </div>
</section>

@section('js')
<script>
    $(".aadb").select2()
    $(function() {
        $("#table-show").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')

        $('.input-format').on('input', function() {
            // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
            var value = $(this).val().replace(/[^0-9]/g, '');

            // Format dengan menambahkan titik koma setiap tiga digit
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang sudah diformat kembali ke input
            $(this).val(formattedValue);
        });
    })

    $(document).on('click', '.btn-tambah-baris', function(e) {
        e.preventDefault();
        var container = $('.section-item');
        var templateRow = $('.section-item').first().clone();
        templateRow.find(':input').val('');
        templateRow.find('.jumlah').val('1');
        templateRow.find('.title').text('Kendaraan ' + (container.length + 1));
        $('.section-item:last').after(templateRow);
        toggleHapusBarisButton();

        templateRow.find('.input-format').on('input', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(formattedValue);
        });
    });

    $(document).on('click', '.btn-hapus-baris', function(e) {
        e.preventDefault();
        var container = $('.section-item');
        if (container.length > 1) {
            $(this).closest('.form-group').prev('.section-item').remove();
            toggleHapusBarisButton();
        } else {
            alert('Minimal harus ada satu baris.');
        }
    });

    $('.btn-hapus-baris').toggle($('.section-item').length > 1);

    function toggleHapusBarisButton() {
        var container = $('.section-item');
        var btnHapusBaris = $('.btn-hapus-baris');
        btnHapusBaris.toggle(container.length > 1);
    }
</script>
@endsection


@endsection
