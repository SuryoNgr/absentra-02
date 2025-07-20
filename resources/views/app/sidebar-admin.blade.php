<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('images/logo-era.png') }}" alt="Logo ERA" class="logo-img">
           
        </div>
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-home"></i></div>
            <span>Beranda</span>
        </a>

        <a href="{{ route('admin.client.index') }}" class="menu-item {{ request()->routeIs('admin.client.*') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-building"></i></div>
            <span>Data Client</span>
        </a>

        <a href="{{ route('admin.supervisor.index') }}" class="menu-item {{ request()->routeIs('admin.supervisor.*') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-user-tie"></i></div>
            <span>Data Supervisor</span>
        </a>


        <a href="{{ route('admin.petugas.index') }}" class="menu-item {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-users-cog"></i></div>
            <span>Data Petugas</span>
        </a>

        <a href="{{ route('admin.data_admin') }}" class="menu-item {{ request()->routeIs('admin.data_admin') ? 'active' : '' }}">
            <div class="menu-icon"><i class="fas fa-user-shield"></i></div>
            <span>Data Admin</span>
        </a>

        <a href="{{ route('admin.absensi.index') }}" class="menu-item" data-page="riwayat-absen">
            <div class="menu-icon"><i class="fas fa-history"></i></div>
            <span>Riwayat Absen</span>
        </a>

        <a href="{{ route('admin.manage-petugas.index') }}" class="menu-item" data-page="manage-petugas">
            <div class="menu-icon"><i class="fas fa-tools"></i></div>
            <span>Manage Petugas</span>
        </a>
    </nav>
</div>
