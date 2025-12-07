@extends('layouts.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        </h4>
        <div class="row">
            <input type="hidden" id="id" value="{{ $jenjang->id }}">

            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="ti-xs ti ti-users me-1"></i>
                            Edit Jenjang</a>
                    </li>
                </ul>
            </div>

            <div class="col-xl-12 col-md-12 mb-4 ">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="col-lg=12">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title mt-4 ">Data Jenjang</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <div class="card-body">
                            <div class="row">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('updateJenjang') }}" method="post" class="row g-3">
                                    {{ csrf_field() }}
                                    <div class="col-12">
                                        <label class="form-label w-100">Nama jenjang</label>
                                        <div class="input-group input-group-merge">
                                            <input name="nama" class="form-control" value="{{ $jenjang->nama }}"
                                                required type="text" placeholder="" />
                                            <input name="id" class="form-control" type="hidden"
                                                value="{{ $jenjang->id }}" />

                                            <span class="input-group-text cursor-pointer p-1" id="modalAddCard2"><span
                                                    class="card-type"></span></span>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label w-100">Jenjang Sebelumnya</label>
                                        <select id="select2" name="jenjang_sebelumnya_id"
                                            class="select2 form-select form-select-lg" data-allow-clear="true">
                                            <option value="{{ $jenjang->jenjang_sebelumnya_id }}">
                                                {{ $jenjang->jenjang_sebelumnya->nama }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label w-100">Jenjang Setelahnya</label>
                                        <select id="select3" name="jenjang_setelahnya_id"
                                            class="select2 form-select form-select-lg" data-allow-clear="true">
                                            <option value="{{ $jenjang->jenjang_setelahnya_id }}">
                                                {{ $jenjang->jenjang_setelahnya->nama }}</option>
                                        </select>
                                    </div>


                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                        <button type="reset" class="btn btn-label-secondary btn-reset"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
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
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/jenjang/edit.js') }}"></script>
    <!-- END: Page JS-->
@endsection
