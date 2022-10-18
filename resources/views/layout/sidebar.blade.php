<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user-cog"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sistem
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::segment(1) == "master" ? 'active' : '' }}">
        <a class="nav-link {{ Request::segment(1) == "master" ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse {{ Request::segment(1) == "master" ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::segment(2) == "stadium" ? 'active' : '' }}" href="{{ route('master-data', 'stadium') }}">Stadium</a>
                <a class="collapse-item {{ Request::segment(2) == "gejala" ? 'active' : '' }}" href="{{ route('master-data', 'gejala') }}">Gejala</a>
                <a class="collapse-item {{ Request::segment(2) == "relasi" ? 'active' : '' }}" href="{{ route('master-data', 'relasi') }}">Relasi</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::is('dokter') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dokter') }}">
            <i class="fas fa-fw fa-hospital-user"></i>
            <span>Data Dokter</span></a>
    </li>

    <li class="nav-item {{ Request::is('daftar-pengguna') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Daftar Pengguna</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ Request::is('laporan-statistik') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan-statistik') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan Statistik</span></a>
    </li>

    <li class="nav-item {{ Request::is('laporan-diagnosa') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan-diagnosa') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Laporan Diagnosa</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
