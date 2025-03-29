<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <img src="{{ file_exists(public_path('assets/img/logovokasi.png')) ? asset('assets/img/logovokasi.png') : 'https://via.placeholder.com/300' }}" style="width: 130px">

            {{-- <a href="">{{ $pengaturan->name ?? config('app.name') }}</a> --}}
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">{{-- {{ strtoupper(substr(config('app.name'), 0, 2)) }} --}}</a>
        </div>
        <ul class="sidebar-menu">
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Kordinator</li>

            <li ><a class="nav-link" href="{{route('tugas.index')}}"><i class="fas fa-file"></i><span>Tugas</span></a></li>

            <li ><a class="nav-link" href="{{route('kelompok.index')}}"><i class="fas fa-users"></i> <span>Kelompok</span></a></li>

            <li ><a class="nav-link" href=""><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>

            <li ><a class="nav-link" href="{{route('pembimbing.index')}}"><i class="fas fa-user"></i> <span>Pembimbing</span></a></li>

            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>

            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Nilai</span></a></li>
            <li class="menu-header">Pembimbing</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>

            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bullhorn"></i> <span>Bimbingan</span></a></li>

            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>


            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Nilai</span></a></li>
            <li class="menu-header">Penguji</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Nilai</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>

            <li class="menu-header">BAAk</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-user"></i> <span>Kordinator</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>

            <li class="menu-header">MahaSiswa</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Artefak</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
        </ul>
    </aside>
</div>
