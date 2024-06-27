@extends('auth.layout.main')
@section('title', 'Login')

@section('content')
<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <div class="avatar avatar-xl">
                        <a href="">
                            <img src="{{ asset('logo.png') }}" alt="logo" class="rounded-circle" height="90px" width="90px">
                        </a>
                    </div>

                    <h3>MTsB App</h3>
                    <span>MTs Bilingual Muslimat NU Pucang Sidoarjo</span>

                    @if(session('response'))
                    <div class="alert alert-light-danger mt-2" role="alert">
                        <strong>{{ session('response') }}</strong>
                    </div>
                    @endif

                    <form class="text-left" action="{{ route('attempt_login') }}" method="POST">
                        <div class="form">
                            @csrf
                            <div id="username-field" class="field-wrapper input">
                                <label for="username">USERNAME</label>
                                <i data-feather="user"></i>
                                <input id="username" name="username" type="text" class="form-control" placeholder="cth: username/nis" value="{{ old('username') }}">
                                @error('username')
                                <small class="text- font-weight-bold">* {{ $message }}</small>
                                @enderror
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">KATA SANDI</label>
                                    <a href="#" class="forgot-pass-link">Lupa kata sandi?</a>
                                </div>
                                <i data-feather="lock"></i>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Kata sandi">
                                <i data-feather="eye" class="eye-toggle"></i>
                                @error('password')
                                <small class="text- font-weight-bold">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" value="">Masuk</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/loaders/custom-loader.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">
@endsection

@section('script')


@endsection
