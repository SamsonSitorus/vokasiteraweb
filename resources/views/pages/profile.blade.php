@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <div class="section">
        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-sm-6 col-lg-6">
                    @include('partials.alert')
                    <div class="card profile-widget">
                       <p>
                        {{session ('name') }}
                       </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
