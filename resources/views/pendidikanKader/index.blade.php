@extends('layouts.base')
@section('css')
<link rel="stylesheet" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Pendidikan</span> Kader</h4>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form class="dt_adv_search" id="cari" method="POST">
                            <div class="row g-3">

                                <div class="col-12">
                                    <h6>Filter Pencarian:</h6>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <label class="form-label">Tahun:</label>
                                    <input type="text" name="tahun" class="form-control dt-input dt-full-name"
                                        onchange="loadData()" data-column="1" placeholder="Tahun"
                                        data-column-index="0" />
                                </div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <label class="form-label">Jenjang:</label>
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="select23" name="jenjang_kaderisasi_id"
                                            aria-label="Default select example" onchange="loadData()">
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addKaderModal"
                            class="btn btn-success waves-effect waves-light float-right">
                            <i class="tf-icons ti ti-plus ti-xs me-1"></i> Penambahan Pendidikan Kader
                        </button>

                    </div>
                  
                </div>
            </div>

            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tahun</th>
                        <th>Pendidikan</th>
                        <th>Status</th>
                        <th>Peserta</th>
                        <th>Peserta Lulus</th>
                        <th>Peserta Tidak Lulus</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kode</th>
                        <th>Tahun</th>
                        <th>Pendidikan</th>
                        <th>Status</th>
                        <th>Peserta</th>
                        <th>Peserta Lulus</th>
                        <th>Peserta Tidak Lulus</th>
                        <th>Opsi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addKaderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Kader </h3>
                </div>
                <form action="{{ route('addKader') }}" method="post" class="row g-3">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <label class="form-label w-100">Nama Anggota</label>
                        <select id="anggota_id" name="anggota_id" class="select2 form-select form-select-lg"
                            data-allow-clear="true">
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label w-100">Jenjang Kader</label>
                        <select id="jenjang_kader_id" name="jenjang_kaderisasi_id"
                            class="select2 form-select form-select-lg" data-allow-clear="true">

                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<!-- BEGIN: Page JS-->
<script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-buttons/datatables-buttons.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jszip/jszip.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/pdfmake/pdfmake.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-buttons/buttons.html5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-buttons/buttons.print.js') }}"></script>
<!-- Flat Picker -->
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<!-- Row Group JS -->
<script src="{{ asset('assets/vendor/libs/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.js') }}"></script>
<!-- Form Validation -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Page JS -->
<script src="{{ asset('assets/js/pendidikan/index.js') }}"></script>
<!-- END: Page JS-->
@endsection