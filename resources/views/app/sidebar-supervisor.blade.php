<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('images/logo-era.png') }}" alt="Logo ERA" class="logo-img">
            <span>Absentra Indonesia</span>
        </div>
    </div>

  <!-- Sidebar Menu -->
    <nav class="sidebar-menu">

        <!-- Beranda -->
         <a href="{{ route('supervisor.dashboard') }}" class="menu-item {{ request()->routeIs('supervisor.home') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-home"></i></div>
            <span>Beranda</span>
        </a>



        <!-- Dropdown: Data Petugas -->
        <a href="{{ route('supervisor.petugas.index') }}" class="menu-item {{ request()->routeIs('supervisor.petugas.*') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-users-cog"></i></div>
            <span>Data Petugas</span>
        </a>


        <!-- Dropdown: Manage Job -->
        <div class="menu-item has-dropdown" onclick="toggleDropdown('dropdown-job')">
            <div class="menu-icon"><i class="fas fa-tools"></i></div>
            <span>Manage Job</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        <div class="submenu" id="dropdown-job">
            <a href="{{ route('supervisor.job.security.index') }}" class="submenu-item"><i class="fas fa-shield-alt"></i> Security Job</a>
            <a href="{{ route('supervisor.job.cleaning.index') }}" class="submenu-item"><i class="fas fa-broom"></i> Cleaning Job</a>
        </div>

        <!-- Riwayat Absen -->
        <a href="{{route('supervisor.absensi.index')}}" class="menu-item">
            <div class="menu-icon"><i class="fas fa-history"></i></div>
            <span>Riwayat Absen</span>
        </a>

        <!-- Aktivitas -->
        <a href="{{route('supervisor.aktivitas.index')}}" class="menu-item">
            <div class="menu-icon"><i class="fas fa-user-shield"></i></div>
            <span>Aktivitas</span>
        </a>

    </nav>
</div>