@extends('layouts.base')
@section('css')
<link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pendidikan Kader {{ $pendidikanKader->jenjang->nama }}  {{ $pendidikanKader->tahun }} /</span> View </h4>
    <div class="row">
        <input type="hidden" name="pendidikan_kader_id" value="{{ $pendidikanKader->id }}" id="id">

        <!-- User Content -->
        <div class="col-xl-12  order-0 order-md-1">
            <!-- Activity Timeline -->
            <div class="card mb-4 h-100">
                <h5 class="card-header">Peserta Pendidikan Kader</h5>
                <div class="card-body pb-0">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#importPeserta"
                    class="btn btn-sm btn-warning waves-effect waves-light float-right">
                    <i class="tf-icons ti ti-plus ti-xs me-1"></i> import Peserta Pendidikan
                </button>
                    <table class="table datatables-basic">
                        <thead>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <strong>Anggota</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Judul Tugas</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Status</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Opsi</strong>
                                </td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Activity Timeline -->
        </div>
        <!--/ User Content -->
    </div>
</div>
<div class="modal fade" id="importPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">import Peserta Pendidikan </h3>
                </div>
                <form action="{{ route('importPeserta', ['pendidikanKader' => $pendidikanKader->id]) }}" method="post" class="row g-3" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <label class="form-label w-100">Import CSV (Template import <a href="contoh_import.xlsx">Contoh File</a href>)</label>
                        <input id="file" name="file" class="form-control" type="file"
                            data-allow-clear="true">
                        </input>
                        <input name="id" class="form-control" value="{{ $pendidikanKader->id }}" type="hidden"  />
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
<div class="modal fade" id="updateEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Status Pendidikan Kader </h3>
                </div>
                <form action="{{ route('updatePesertaPendidikan') }}" method="post" class="row g-3">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <label class="form-label w-100">Nama Anggota</label>
                        <input name="nama" class="form-control" id="nama" type="text" disabled
                            value="" placeholder="" />
                        <input name="id" class="form-control" id="ids" type="hidden" 
                           placeholder="" />
                    </div>

                    <div class="col-12">
                        <label class="form-label w-100">Judul Tugas</label>
                        <input name="judul_task" id="judul" class="form-control" type="text" 
                        value="" placeholder="" />
                    </div>
                  
                    <div class="col-12">
                        <label class="form-label w-100">status</label>
                        <select id="select3" name="status" id="status" class=" form-select form-select"
                            data-allow-clear="true">
                            <option value="1">Aktif</option>
                            <option value="2">Lulus</option>
                            <option value="3">Tidak Lulus</option>
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

<!-- BEGIN: Page JS-->
@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
</script>

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
<script src="{{ asset('assets/js/pendidikan/view.js') }}"></script>
@endsection