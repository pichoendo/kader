<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Sistem Managemen Anggota ABI.">
    <meta name="keywords" content="sistem, management, anggota, iuran">

    <title>SIKADER - Sistem Kaderisasi ABI</title>

    <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/ico/favicon.ico')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->



</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>
    <div class="authentication-wrapper authentication-basic px-4">

        <div class="authentication-inner py-4">
            <!--  Two Steps Verification -->
            <div class="card">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg id="logo" viewbox="0 0 139 95" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="26">
                                    <defs>
                                        <linearGradient gradientUnits="userSpaceOnUse" x1="233.465" y1="151.609"
                                            x2="233.465" y2="161.445" id="gradient-4"
                                            gradientTransform="matrix(0.169928, -1.485617, 2.584047, 0.295566, -323.344607, 320.599746)">
                                            <stop offset="0" style="stop-color: rgba(251, 154, 154, 1)" />
                                            <stop offset="1" style="stop-color: rgba(247, 56, 56, 1)" />
                                        </linearGradient>
                                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012"
                                            x2="217.262" y2="352.566" id="gradient-3"
                                            gradientTransform="matrix(-0.041878, -0.966623, 0.241717, -0.081529, 155.312844, 436.803954)">
                                            <stop offset="0" style="stop-color: rgb(169, 255, 205);" />
                                            <stop offset="1" style="stop-color: rgb(117, 230, 170);" />
                                        </linearGradient>
                                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012"
                                            x2="217.262" y2="352.566" id="gradient-5"
                                            gradientTransform="matrix(-1.382843, 0.36849, -0.094072, -0.353023, 637.621826, 468.833038)">
                                            <stop offset="0" style="stop-color: rgb(123, 255, 178);" />
                                            <stop offset="1" style="stop-color: rgb(60, 215, 156);" />
                                        </linearGradient>
                                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012"
                                            x2="217.262" y2="352.566" id="gradient-1"
                                            gradientTransform="matrix(-1.34598, -0.486196, 0.056099, -0.155305, 586.690503, 616.17284)">
                                            <stop offset="0" style="stop-color: rgb(116, 230, 164);" />
                                            <stop offset="1" style="stop-color: rgb(173, 250, 210);" />
                                        </linearGradient>
                                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012"
                                            x2="217.262" y2="352.566" id="gradient-2"
                                            gradientTransform="matrix(-0.475526, 1.319917, -0.227764, -0.027958, 482.260444, 10.730844)">
                                            <stop offset="0" style="stop-color: rgb(118, 231, 171);" />
                                            <stop offset="1" style="stop-color: rgb(169, 255, 205);" />
                                        </linearGradient>
                                    </defs>
                                    <circle style="fill: url(#gradient-4);" cx="116.716" cy="18.663" r="7.354" />
                                    <rect x="211.446" y="164.771" width="23.166" height="46.147"
                                        style="fill: url(#gradient-3);" rx="11.583" ry="11.583"
                                        transform="matrix(0.91792, 0.396765, -0.396765, 0.91792, -16.127542, -203.624939)" />
                                    <rect x="294.347" y="400.725" width="33.152" height="103.832"
                                        style="fill: url(#gradient-5);" rx="16.889" ry="16.889"
                                        transform="matrix(0.855229, 0.518251, -0.518251, 0.855229, 15.554746, -500.078033)" />
                                    <rect x="294.347" y="400.725" width="33.152" height="103.832"
                                        style="fill: url(#gradient-1);" rx="16.889" ry="16.889"
                                        transform="matrix(0.866025, -0.5, 0.5, 0.866025, -412.915161, -188.877716)" />
                                    <rect x="294.348" y="257.432" width="33.152" height="66.703"
                                        style="fill: url(#gradient-2);" rx="16.889" ry="16.889"
                                        transform="matrix(0.879849, 0.475253, -0.475253, 0.879849, -27.084703, -340.168213)" />

                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bold ms-1">SIKADER</span>
                        </a>
                    </div>
                    @foreach( $errors->all() as $message)
                    <input type="hidden" id="errors" value="{{$message}}" />
                    @endforeach
                    <!-- /Logo -->
                    <h4 class="mb-1 pt-2">Selamat Datang</h4>
                    <form id="twoStepsForm" action="auth" method="POST">
                        <div class="mb-3 fv-plugins-icon-container">
                            <label for="email" class="form-label">No Kontak :</label>
                            <input type="text" class="form-control" id="no_kontak" name="no_kontak"
                                placeholder="Masukan No Kontak Anda" autofocus="">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                        <p class="mb-0 fw-semibold">Ketik Kode OTP Anda</p>
                        <span class="text-light">Gunakan 12345 Untuk Demo Login</span>
                        {{csrf_field()}}
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" autofocus />
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" />
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" />
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" />
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" />
                            </div>
                            <!-- Create a hidden field which is combined by 3 fields above -->
                            <input type="hidden" id='otp' name="otp" />
                            <input type="hidden" id='password' name="password" />
                        </div>
                        <button class="btn btn-warning d-grid w-100 mb-3" type="button" onclick="requestOtp()">Request
                            OTP</button>
                        <button class="btn btn-primary d-grid w-100 mb-3" type="submit">Verify my account</button>

                    </form>
                </div>
            </div>
            <!-- / Two Steps Verification -->
        </div>
    </div>
    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/node-waves/node-waves.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>

    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->
    <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('assets/js/pages-auth.js')}}"></script>
    <script src="{{asset('assets/js/pages-auth-two-steps.js?v=2')}}"></script>
    <script>
        var wait = 0
        var csrf = $('input[name="_token"]').val();
        $('#otp').on('input', function (e) {
            alert(e.currentTarget.value)
            $('#password').val($('#otp').val())
        })
        function showMessage(message, i) {
            var mode = ['warning', 'success']
            toastr[mode[i]](message, 'INFO', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false
            });
        }

        if ($('#errors').val().length > 0)
            showMessage($('#errors').val(), 0);
        var interval;

        function startIntervals() {
            interval = setInterval(function () {
                wait--;
                $('#btn-request').empty().append('Tunggu (' + (wait.toString().toHHMMSS()) + ")")
                if (wait <= 0) {
                    clearInterval(interval);
                    $('#btn-request').empty().append('Request OTP')
                    $('#btn-request').attr('disabled', true)
                }
            }, 1000);

        }

        function requestOtp() {
            if ($('#no_kontak').val().length == 0) {
                showMessage("Mohon Isi No Kontak Terlebih Dahulu", 1)
                return false
            }
            $.ajax({
                url: "requestOTP",
                type: "post",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('csrf-Token', csrf);
                },
                data: {
                    '_token': csrf,
                    'no_kontak': $('#no_kontak').val()
                },
                success: function (response) {
                    console.log(response)
                    wait = response.wait
                    if (response.code == 200) {
                        showMessage(response.message, 1)
                    } else {
                        showMessage(response.message, 0)
                    }
                    if (response.wait != -1) {
                        if (interval)
                            clearInterval(interval);
                        $('#btn-request').attr('disabled', true)
                        startIntervals()
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

    </script>
</body>
<!-- END: Body-->

</html>