@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="section">
    <div class="section-body">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-8 col-lg-6">
                @include('partials.alert')

                @foreach($detailUser as $user)
                <div class="card profile-widget">
                    <div class="profile-widget-header text-center pt-4">
                        <img alt="image" src="{{ asset('assets/img/default-profile.png') }}" class="rounded-circle profile-widget-picture" width="100">
                        <h4 class="mt-3">{{ $user['nama'] }}</h4>
                        <div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> {{ $user['prodi_name'] }}
                        </div>
                    </div>
                    <div class="profile-widget-description px-4 py-3">
                        <ul class="list-unstyled">
                            <li><strong>NIM:</strong> {{ $user['nim'] }}</li>
                            <li><strong>Username:</strong> {{ $user['user_name'] }}</li>
                            <li><strong>Email:</strong> {{ $user['email'] }}</li>
                            <li><strong>Fakultas:</strong> {{ $user['fakultas'] }}</li>
                            <li><strong>Angkatan:</strong> {{ $user['angkatan'] }}</li>
                            <li><strong>Status:</strong> 
                                <span class="badge {{ $user['status'] == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user['status'] }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
