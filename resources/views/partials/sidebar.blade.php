<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <img src="{{ file_exists(public_path('assets/img/logovokasi.png')) ? asset('assets/img/logovokasi.png') : 'https://via.placeholder.com/300' }}" style="width: 130px">
        @if (session('isLoggin'))
    <p>User Logged In as: {{ session('role') }}</p>
@else
    <p>Tidak ada pengguna yang login.</p>
@endif
@if (Auth::check())
    <p>User Logged In as: {{ Auth::user()->role }}</p>
@else
    <p>Tidak ada pengguna yang login.</p>
@endif

        </div>
        @if (session('isLoggin'))
        <ul class="sidebar-menu">
            @if (session('role') == 'Dosen')
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Kordinator</li>
            <li ><a class="nav-link" href="{{route('tugas.index')}}"><i class="fas fa-file"></i><span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{route('kelompok.index')}}"><i class="fas fa-users"></i> <span>Kelompok</span></a></li>
            <li ><a class="nav-link" href=""><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            <li ><a class="nav-link" href="{{route('pembimbing.index')}}"><i class="fas fa-user"></i> <span>Pembimbing</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Nilai</span></a></li>
            @elseif (session('role') == 'Mahasiswa')
            <li class="menu-header">MahaSiswa</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Artefak</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            @elseif (session('role') == 'Penguji')
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bullhorn"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Nilai</span></a></li>
            @elseif (session('role') == 'Staff')
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{route('koordinator.index')}}"><i class="fas fa-user"></i> <span>Kordinator</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            @else 
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Nilai</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            @endif
        </ul>
         @endif
    </aside>
</div>
