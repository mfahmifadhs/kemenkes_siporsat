@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-9">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Usulan Permintaan BBM</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-9">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary border border-dark">
                    <div class="card-header">
                        <label class="card-title">
                            Usulan Permintaan BBM
                        </label>
                    </div>
                    <form id="form" action="{{ route('usulan.store', 'bbm') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <label for="tanggal">Bulan Permintaan</label>
                            <input type="month" class="form-control" name="bulan_permintaan" value="{{ Carbon\Carbon::now() }}" required>
                        </div>
                        <div class="card-body" style="overflow-y: auto; max-height: 70vh;">
                            <label for="aadb">Daftar AADB</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th style="width: 15%;">No. Polisi</th>
                                            <th>Kendaraan</th>
                                            <th>Merk/Tipe</th>
                                            <th>
                                                <input type="checkbox" id="selectAll" style="scale: 1.7;">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs">
                                        @foreach ($aadb as $i => $row)
                                        <tr class="text-uppercase">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $row->no_polisi }}</td>
                                            <td>{{ $row->kategori->nama_kategori }}</td>
                                            <td>{{ $row->merk_tipe }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" class="confirm-check" data-id="{{ $row->id_aadb }}" style="scale: 1.7;" value="{{ $row->id_aadb }}">
                                                <div id="hidden-container"></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right border-top border-dark">
                            <button class="btn btn-primary btn-sm font-weight-bold" onclick="confirmSubmit(event, 'form')">
                                <i class="fas fa-paper-plane"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectAllCheckbox = document.getElementById("selectAll");
        let checkboxes = document.querySelectorAll(".confirm-check");
        let hiddenContainer = document.getElementById("hidden-container");

        // Select All Checkbox
        selectAllCheckbox.addEventListener("change", function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
                toggleHiddenInput(checkbox);
            });
        });

        // Event Listener untuk Checkbox Individu
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                toggleHiddenInput(checkbox);
            });
        });

        // Fungsi Menambah/Menghapus Input Hidden
        function toggleHiddenInput(checkbox) {
            let aadbId = checkbox.getAttribute("data-id");
            let existingInput = document.getElementById("hidden-aadb-" + aadbId);

            if (checkbox.checked) {
                if (!existingInput) {
                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "aadb[]";
                    hiddenInput.value = aadbId;
                    hiddenInput.id = "hidden-aadb-" + aadbId;
                    hiddenContainer.appendChild(hiddenInput);
                }
            } else {
                if (existingInput) {
                    existingInput.remove();
                }
            }
        }
    });
</script>
@endsection
@endsection
