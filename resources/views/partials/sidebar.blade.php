<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <img src="{{ file_exists(public_path('assets/img/logovokasi.png')) ? asset('assets/img/logovokasi.png') : 'https://via.placeholder.com/300' }}" style="width: 130px">
        @if (session('isLoggin'))
    <p>User Logged In as: {{ session('role') }}</p>
@else
    <p>Tidak ada pengguna yang login.</p>
@endif

        </div>
        @if (session('isLoggin'))
        <ul class="sidebar-menu">
            @if (session('role') == 'Dosen')
            @php $dosenRoles = session('dosen_roles'); @endphp
            {{--  untuk Koordinator --}}
            @if (in_array(1, $dosenRoles)) 
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Kordinator</li>
            <li ><a class="nav-link" href="{{--route('tugas.index')--}}"><i class="fas fa-file"></i><span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{ route('kelompok.index')}}"><i class="fas fa-users"></i> <span>Kelompok</span></a></li>
            <li ><a class="nav-link" href=""><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            <li ><a class="nav-link" href="{{--route('pembimbing.index')--}}"><i class="fas fa-user"></i> <span>Pembimbing</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Nilai</span></a></li>
            @endif
            {{--  untuk Penguji --}}
            @if (in_array(2, $dosenRoles) || in_array(4, $dosenRoles)) 
            <li class="menu-header">Penguji</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bullhorn"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Nilai</span></a></li>
            @endif
            {{-- Untuk  Pembimbing --}}
            @if (in_array(3, $dosenRoles) || in_array(5, $dosenRoles)) 
            <li class="menu-header">Pembimbing</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Nilai</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            @endif
             {{-- Untuk  Mahasiswa --}}
            @elseif (session('role') == 'Mahasiswa')
            <li class="menu-header">MahaSiswa</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-file"></i> <span>Artefak</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
           
             {{-- Untuk Staff --}}
            @elseif (session('role') == 'Staff')
            <li class="menu-header">Staff</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{route('manajemen-role.index')}}"><i class="fas fa-user"></i> <span>Manajemen-Role</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            @endif
        </ul>
        @endif
    </aside>
</div>
