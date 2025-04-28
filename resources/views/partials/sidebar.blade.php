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
             <li ><a class="nav-link" href="{{ route('tugas.index')}}"><i class="fas fa-file"></i><span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{ route('kelompok.index')}}"><i class="fas fa-users"></i> <span>Kelompok</span></a></li>
            <li ><a class="nav-link" href="{{ route('jadwal.index')}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            <li class="nav-item dropdown {{ request()->is('pembimbing*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-user"></i> <span>Pembimbing</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link {{ request()->routeIs('pembimbing.index') ? 'active' : '' }}" href="{{ route('pembimbing.index') }}">Pembimbing 1</a></li>
                    <li><a class="nav-link {{ request()->routeIs('pembimbing2.index') ? 'active' : '' }}" href="{{ route('pembimbing2.index') }}">Pembimbing 2</a></li>
                </ul>
            </li>      
            <li class="nav-item dropdown {{ request()->is('penguji*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-user"></i> <span>Penguji</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link {{ request()->routeIs('penguji.index') ? 'active' : '' }}" href="{{route('penguji.index')}}">Penguji 1</a></li>
                    <li><a class="nav-link {{ request()->routeIs('penguji2.index') ? 'active' : '' }}" href="{{route('penguji2.index')}}">Penguji 2</a></li>
                </ul>
            </li>        
            <li class="nav-item dropdown {{ request()->is('nilai*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Nilai</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link {{ request()->routeIs('NilaiKelompok.index') ? 'active' : '' }}" href="{{ route('NilaiKelompok.index') }}">Nilai Kelompok </a></li>
                    <li><a class="nav-link {{ request()->routeIs('NilaiMahasiswa.index') ? 'active' : '' }}" href="{{ route('NilaiMahasiswa.index') }}">Nilai Individu</a></li>
                </ul>
            </li>    
            <li ><a class="nav-link" href="{{ route('pengumuman.index')}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            @endif
            {{--  untuk Penguji --}}
            @if (in_array(2, $dosenRoles) || in_array(4, $dosenRoles)) 

            <li class="menu-header">Penguji</li><li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{ route('penguji.jadwal.index') }}"><i class="fas fa-file"></i> <span>Jadwal</span></a></li>
            <li ><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-list"></i> <span>Nilai</span></a></li>

            <li class="menu-header">Penguji</li>            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{route('penguji.tugas.index')}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar"></i> <span>Nilai</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{--  --}}">Nilai Kelompok</a></li>
                    <li><a class="nav-link" href="{{--  --}}">Nilai Mahasiswa</a></li>
                </ul>
            </li>
            <li ><a class="nav-link" href="{{--route('pembimbing.pengumuman.index')--}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
          
            @endif
            {{-- Untuk  Pembimbing --}}
            @if (in_array(3, $dosenRoles) || in_array(5, $dosenRoles)) 
            <li class="menu-header">Pembimbing</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{route('pembimbing.tugas.index')}}"><i class="fas fa-file"></i> <span>Tugas</span></a></li>
            <li ><a class="nav-link" href="{{route('pembimbing.bimbingan.index')}}"><i class="fas fa-bullhorn"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{route('pengumuman.pembimbing.index')}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li class="nav-item dropdown {{ request()->is('nilai*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Nilai</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link {{ request()->routeIs('NilaiKelompok.index') ? 'active' : '' }}" href="{{ route('NilaiKelompok.index') }}">Nilai Kelompok </a></li>
                    <li><a class="nav-link {{ request()->routeIs('NilaiMahasiswa.index') ? 'active' : '' }}" href="{{ route('NilaiMahasiswa.index') }}">Nilai Individu</a></li>
                </ul>
            </li>  
            
            @endif
             {{-- Untuk  Mahasiswa --}}
            @elseif (session('role') == 'Mahasiswa')
            <li class="menu-header">MahaSiswa</li>
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{-- routesnya --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{ route('artefak.index')}}"><i class="fas fa-file"></i> <span>Artefak</span></a></li>
            <li ><a class="nav-link" href="{{route('bimbingan.index')}}"><i class="fas fa-list"></i> <span>Bimbingan</span></a></li>
            <li ><a class="nav-link" href="{{route('pengumuman.mahasiswa.index')}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{route('mahasiswa.jadwal.index')}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
           
             {{-- Untuk Staff --}}
            @elseif (session('role') == 'Staff')
            <li class="menu-header">Staff</li>
            <li><a class="nav-link" href="{{-- {{ route('admin.dashboard') }} --}}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li ><a class="nav-link" href="{{route('manajemen-role.index')}}"><i class="fas fa-user"></i> <span>Manajemen-Role</span></a></li>
            <li ><a class="nav-link" href="{{route('baak.jadwal.index')}}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            <li ><a class="nav-link" href="{{ route('pengumuman.BAAK.index')}}"><i class="fas fa-bell"></i> <span>Pengumuman</span></a></li>
            <li ><a class="nav-link" href="{{ route('TahunMasuk.index')}}"><i class="fas fa-graduation-cap"></i> <span>Tahun Ajaran</span></a></li>
            @endif
        </ul>
        @endif
    </aside>
</div>
