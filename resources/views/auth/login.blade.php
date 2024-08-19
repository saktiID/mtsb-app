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
                    <div class="alert alert-danger mt-2" role="alert">
                        <strong>{{ session('response') }}</strong>
                    </div>
                    @endif

                    {{-- install app --}}
                    <div id="installWrap" class="mt-3">
                        <div class="alert alert-gradient mb-3" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i data-feather="x"></i></button>
                            <strong>Install</strong> aplikasi yuk!
                            <button id="installButton" class="btn btn-warning btn-sm"></button>
                        </div>
                    </div>
                    {{-- end install app --}}

                    <form class="text-left" action="{{ route('attempt_login') }}" method="POST">
                        <div class="form">
                            @csrf
                            <div id="username-field" class="field-wrapper input">
                                <label for="username">USERNAME</label>
                                <i data-feather="user"></i>
                                <input id="username" name="username" type="text" class="form-control" placeholder="cth: username/nis" value="{{ old('username') }}">
                                @error('username')
                                <small class="text-danger font-weight-bold">* {{ $message }}</small>
                                @enderror
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">KATA SANDI</label>
                                    {{-- <a href="#" class="forgot-pass-link">Lupa kata sandi?</a> --}}
                                </div>
                                <i data-feather="lock"></i>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Kata sandi" autocomplete="on">
                                <i data-feather="eye" class="eye-toggle"></i>
                                @error('password')
                                <small class="text-danger font-weight-bold">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary loadingTrigger" value="">Masuk</button>
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
<link rel="stylesheet" href="{{ asset('plugins/loaders/custom-loader.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">
@endsection

@section('script')
<script>
    let eyeToggel = document.querySelector('.eye-toggle')
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')
    loadingTrigger.forEach(function(loading) {
        loading.addEventListener('click', function(e) {
            if (loading.classList.contains('tambah')) {
                if (checkForm()) {
                    loadingSpin()
                }
            } else {
                loadingSpin()
            }

            function loadingSpin() {
                textLoadingtrigger = loading.innerHTML
                const spinner = document.createElement('div')
                spinner.classList = "spinner-border text-white align-self-center loader-sm"
                loading.replaceChild(spinner, loading.childNodes[0])
            }

        })
    })
    eyeToggel.addEventListener('click', function(e) {
        let password = document.getElementById('password')
        if (password.type === 'password') {
            password.type = 'text'
        } else {
            password.type = 'password'
        }
    })

</script>

@endsection
