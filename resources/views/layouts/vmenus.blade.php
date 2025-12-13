<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('monitoring') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg id="logo" viewbox="0 0 139 95" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="26">
                    <defs>
                        <linearGradient gradientUnits="userSpaceOnUse" x1="233.465" y1="151.609" x2="233.465"
                            y2="161.445" id="gradient-4"
                            gradientTransform="matrix(0.169928, -1.485617, 2.584047, 0.295566, -323.344607, 320.599746)">
                            <stop offset="0" style="stop-color: rgba(251, 154, 154, 1)" />
                            <stop offset="1" style="stop-color: rgba(247, 56, 56, 1)" />
                        </linearGradient>
                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012" x2="217.262"
                            y2="352.566" id="gradient-3"
                            gradientTransform="matrix(-0.041878, -0.966623, 0.241717, -0.081529, 155.312844, 436.803954)">
                            <stop offset="0" style="stop-color: rgb(169, 255, 205);" />
                            <stop offset="1" style="stop-color: rgb(117, 230, 170);" />
                        </linearGradient>
                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012" x2="217.262"
                            y2="352.566" id="gradient-5"
                            gradientTransform="matrix(-1.382843, 0.36849, -0.094072, -0.353023, 637.621826, 468.833038)">
                            <stop offset="0" style="stop-color: rgb(123, 255, 178);" />
                            <stop offset="1" style="stop-color: rgb(60, 215, 156);" />
                        </linearGradient>
                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012" x2="217.262"
                            y2="352.566" id="gradient-1"
                            gradientTransform="matrix(-1.34598, -0.486196, 0.056099, -0.155305, 586.690503, 616.17284)">
                            <stop offset="0" style="stop-color: rgb(116, 230, 164);" />
                            <stop offset="1" style="stop-color: rgb(173, 250, 210);" />
                        </linearGradient>
                        <linearGradient gradientUnits="userSpaceOnUse" x1="217.262" y1="280.012" x2="217.262"
                            y2="352.566" id="gradient-2"
                            gradientTransform="matrix(-0.475526, 1.319917, -0.227764, -0.027958, 482.260444, 10.730844)">
                            <stop offset="0" style="stop-color: rgb(118, 231, 171);" />
                            <stop offset="1" style="stop-color: rgb(169, 255, 205);" />
                        </linearGradient>
                    </defs>
                    <circle style="fill: url(#gradient-4);" cx="116.716" cy="18.663" r="7.354" />
                    <rect x="211.446" y="164.771" width="23.166" height="46.147" style="fill: url(#gradient-3);"
                        rx="11.583" ry="11.583"
                        transform="matrix(0.91792, 0.396765, -0.396765, 0.91792, -16.127542, -203.624939)" />
                    <rect x="294.347" y="400.725" width="33.152" height="103.832" style="fill: url(#gradient-5);"
                        rx="16.889" ry="16.889"
                        transform="matrix(0.855229, 0.518251, -0.518251, 0.855229, 15.554746, -500.078033)" />
                    <rect x="294.347" y="400.725" width="33.152" height="103.832" style="fill: url(#gradient-1);"
                        rx="16.889" ry="16.889"
                        transform="matrix(0.866025, -0.5, 0.5, 0.866025, -412.915161, -188.877716)" />
                    <rect x="294.348" y="257.432" width="33.152" height="66.703" style="fill: url(#gradient-2);"
                        rx="16.889" ry="16.889"
                        transform="matrix(0.879849, 0.475253, -0.475253, 0.879849, -27.084703, -340.168213)" />

                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">SI<span class="text-success">Kader</span></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item @if (Route::is('monitoring')) active @endif">
            <a href="{{ route('monitoring') }}" class="menu-link ">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboard Monitoring</div>
            </a>
        </li>

        <!-- SURAT -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">KADER</span>
        </li>

        <li class="menu-item @if (Route::is('kader')) active @endif">
            <a href="{{ route('kader') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Data Kader">Data Kader</div>
            </a>
        </li>
        <li class="menu-item @if (Route::is('pendidikanKader')) active @endif">
            <a href="{{ route('pendidikanKader') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-book"></i>
                <div data-i18n="Data Pendidikan Kader">Data Pendidikan Kader</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">FEEDBACK</span>
        </li>

        <li class="menu-item @if (Route::is('feedback')) active @endif">
            <a href="{{ route('feedback') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-message-dots"></i>
                <div data-i18n="Feedback">Feedback</div>
            </a>
        </li>

        <!-- ACARA -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">REFERENSI</span>
        </li>

        <li class="menu-item @if (Route::is('jenjang')) active @endif">
            <a href="{{ route('jenjang') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-tools"></i>
                <div data-i18n="Jenjang Pend. Kader">Jenjang Pend. Kader</div>
            </a>
        </li>

        <!-- ABSENSI -->
        <l </ul>
</aside>