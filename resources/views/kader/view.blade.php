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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kader /</span> View </h4>
    <div class="row">
        <input type="hidden" name="anggota_id" value="{{ $anggota->id }}" id="id">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="http://12gbi.info/{{ $anggota->photo }}"
                                height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h5 class="mb-2 small">{{ $anggota->kode }}</h5>
                                <h4 class="">{{ $anggota->nama_lengkap }}</h4>
                                <h4 class="badge bg-label-success text-success">
                                    {{ $anggota->organisasi->nama }} DPD
                                    {{ $anggota->dpd->nama }}</span></h4>
                                <br>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#updateJenjangModal"
                                    class="btn btn-success btn-sm  waves-effect waves-light float-right">
                                    Update Jenjang Kader
                                </button>

                            </div>
                        </div>
                    </div>


                    <p class="mt-4 small text-uppercase text-muted">Details</p>
                    <div class="info-container">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="align-top"><strong>Jenis Kelamin</strong>:</td>
                                    <td> <span>{{ $anggota->jenis_kelamin == 0 ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top"><strong>Umur</strong>:</td>
                                    <td> <span>{{ $anggota->umur }}</span></td>
                                </tr>
                                <tr>
                                    <td class="align-top"><strong>E-mail</strong>:</td>
                                    <td> <span>{{ $anggota->email }}</span></td>
                                </tr>
                                <tr>
                                    <td class="align-top"><strong>No Kontak</strong>:</td>
                                    <td> <span>{{ $anggota->no_kontak }}</span></td>
                                </tr>
                                <tr>
                                    <td class="align-top"><strong>Alamat</strong>:</td>
                                    <td> <span>{{ $anggota->alamat }}</span></td>
                                </tr>

                                <hr>
                                <tr>
                                    <td class="align-top"><strong>Tanggal Daftar</strong>:</td>
                                    <td class="align-top"> <span>{{ $anggota->created_at }}</span></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Activity Timeline -->
            <div class="card mb-4 h-100">
                <h5 class="card-header">Riwayat Pendidikan Kader</h5>
                <div class="card-body pb-0">
                    <table class="table datatables-basic">
                        <thead>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <strong>Tanggal</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Jenjang</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Tempat</strong>
                                </td>
                                <td class="align-top">
                                    <strong>Keterangan</strong>
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
<div class="modal fade" id="updateJenjangModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Kader </h3>
                </div>
                <form action="{{ route('updateJenjangAnggota') }}" method="post" class="row g-3">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <label class="form-label w-100">Nama Anggota</label>

                        <input name="nama" class="form-control" type="text" disabled
                            value="{{ $anggota->nama_lengkap }}" placeholder="" />
                           
                        <input name="id" class="form-control" type="hidden" value="{{ $anggota->id }}" />


                    </div>
                    <div class="col-12">
                        <label class="form-label w-100">Jenjang Kader</label>
                        <select id="select3" name="jenjang_kaderisasi_id" class="select2 form-select form-select-lg"
                            data-allow-clear="true">

                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label w-100">Tanggal</label>
                        <input name="tanggal" class="form-control" type="date" 
                        value="" placeholder="" />
                    </div>
                    <div class="col-12">
                        <label class="form-label w-100">Tempat</label>
                        <input name="tempat" class="form-control" type="text" 
                        value="" placeholder="" />
                    </div>
                    <div class="col-12">
                        <label class="form-label w-100">Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
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

<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/kader/view.js') }}"></script>
@endsection