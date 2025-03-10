@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-10">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Usulan</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('usulan','ukt') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('usulan.detail', $data->id_usulan) }}"> Detail</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-10">
        <div class="card border border-dark">
            <form id="form" action="{{ route('usulan.update', $id) }}" method="POST">
                @csrf
                <div class="card-header font-weight-bold mt-2">
                    Edit Usulan Kerumahtanggaan
                    <h6 class="text-muted small">
                        Pekerjaan yang berkaitan dengan urusan kerumahtanggaan, seperti pembelian
                        sewa tanaman, akun zoom dan lain sebagainya
                    </h6>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 60vh;">
                    @foreach ($data->detail as $row)
                    <input type="hidden" name="id_detail[]" value="{{ $row->id_detail }}">
                    <div class="form-group row">
                        <label class="col-md-12 mb-2 title font-weight-bold">
                            <a href="#" onclick="confirmLink(event, `{{ route('usulan.deleteItem', $row->id_detail) }}`)" class="btn btn-default btn-xs bg-danger rounded">
                                <i class="fas fa-trash-alt p-1" style="font-size: 10px;"></i>
                            </a>
                            Pekerjaan {{ $loop->iteration }}
                        </label>
                        <div class="col-md-12">
                            <label class="col-form-label">Nama Pekerjaan</label>
                            <input type="text" class="form-control" name="judul[]" max="100" placeholder="Contoh : Pembelian Sewa Zoom (Max. 100 Karakter)" value="{{ $row->judul }}" required>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="col-form-label">Uraian</label>
                            <textarea name="uraian[]" class="form-control" rows="10" placeholder="Contoh : Sewa zoom meeting untuk 1 tahun dengan kapasitas 100 orang" required>{{ $row->uraian }}</textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="col-form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan[]" rows="10" placeholder="Keterangan Tambahan">{{ $row->keterangan }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    @endforeach

                    <input type="hidden" name="id_detail[]" value="">
                    <div class="form-group row section-item d-none">
                        <label class="col-md-12 mb-2 title font-weight-bold">Pekerjaan {{ $data->detail->count() + 1 }}</label>
                        <div class="col-md-12">
                            <label class="col-form-label">Nama Pekerjaan</label>
                            <input type="text" class="form-control judul" max="100" placeholder="Contoh : Pembelian Sewa Zoom (Max. 100 Karakter)">
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="col-form-label">Uraian</label>
                            <textarea class="form-control uraian" rows="10" placeholder="Contoh : Sewa zoom meeting untuk 1 tahun dengan kapasitas 100 orang"></textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="col-form-label">Keterangan</label>
                            <textarea class="form-control keterangan" rows="10" placeholder="Keterangan Tambahan"></textarea>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-5 mt-2">
                            <a href="" class="small btn btn-primary btn-xs btn-tambah-baris">
                                <i class="fas fa-plus"></i> Tambah Baris
                            </a>
                            <a href="" class="small btn btn-danger btn-xs btn-hapus-baris">
                                <i class="fas fa-times"></i> Hapus Baris
                            </a>
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
    $(function() {
        $(".kategori").select2()
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
        var totalNum    = parseInt('{{ $data->detail->count() }}', 10);
        var container   = $('.section-item');
        var templateRow = $('.section-item').first().clone();
        templateRow.find(':input').val('');
        templateRow.find('.jumlah').val('1');
        templateRow.find('.title').text('Pekerjaan ' + (totalNum + container.length));
        templateRow.find('.judul').attr('required', true).attr("name", "judul[]");        ;
        templateRow.find('.uraian').attr('required', true).attr("name", "uraian[]");
        templateRow.find('.keterangan').attr("name", "keterangan[]");
        templateRow.removeClass('d-none');
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
