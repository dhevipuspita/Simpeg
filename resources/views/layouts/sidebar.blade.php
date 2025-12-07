<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ url('assets/img/logo-pondok.png') }}" alt="Logo Pondok" style="max-height: 25px; ;">
            </span>
            <span class="app-brand-text demo menu-text fw-bold" style="font-size: 15px; ">Pendidikan Islam
                <br>Al Alzhar</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-2"></i>
                <div>Dashboard</div>
            </a>
        </li>

        @if (Auth::user()->roleId == 1)
            <li
                class="menu-item {{ Route::currentRouteName() == 'guru.index' || Route::currentRouteName() == 'pengurus.index' || Route::currentRouteName() == 'santri.index' || Route::currentRouteName() == 'inputMatpelSantri.index' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle ">
                    <i class="menu-icon tf-icons ti ti-devices-pc"></i>
                    <div>Sistem</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::currentRouteName() == 'staff.index' ? 'active' : '' }}">
                        <a href="{{ route('staff.index') }}" class="menu-link">
                            <div>Data Diri Pegawai</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() == 'data-induk.index' ? 'active' : '' }}">
                        <a href="{{ route('data-induk.index') }}" class="menu-link">
                            <div>Data Induk Staff</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() == 'riwayat.index' ? 'active' : '' }}">
                        <a href="{{ route('riwayat.index') }}" class="menu-link">
                            <div>Riwayat Kepegawaian</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() == 'jenis.index' ? 'active' : '' }}">
                        <a href="{{ route('jenis.index') }}" class="menu-link">
                            <div>Jenis Golongan Pegawai</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() == 'jenjang.index' ? 'active' : '' }}">
                        <a href="{{ route('jenjang.index') }}" class="menu-link">
                            <div>Jenjang</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() == 'reset.index' ? 'active' : '' }}">
                        <a href="{{ route('reset.index') }}" class="menu-link">
                            <div>Reset Password</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

       <li class="menu-item {{ Route::currentRouteName() == 'bpjs.index' ? 'active' : '' }}">
            <a href="{{ route('bpjs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file-certificate"></i>
                <div>BPJS</div>
            </a>
        </li>
        @if (in_array(Auth::user()->roleId, [1, 3]))
            <li class="menu-item {{ Route::currentRouteName() == 'perizinan.index' ? 'active' : '' }}">
                <a href="{{ route('perizinan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail-opened"></i>
                    <div>Perizinan Cuti</div>
                </a>
            </li>
        @endif
      <li class="menu-item {{ Route::currentRouteName() == 'resign.index' ? 'active' : '' }}">
    <a href="{{ route('resign.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user-x"></i>
        <div>Resign</div>
    </a>
</li>
        <li class="menu-item {{ Route::currentRouteName() == 'profile.index' ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-user"></i>
                <div>Profile</div>
            </a>
        </li>
    </ul>
</aside>
