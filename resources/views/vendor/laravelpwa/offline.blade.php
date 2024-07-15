@extends('auth.layout.main')
@section('title', 'Offline')
@section('content')
<style>

</style>

<div class="form-container outer bg-danger">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="px-5">

                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>

                    <h4 class="text-white mt-3">Tidak ada koneksi internet</h4>
                    <h6 class="text-white mb-3">Silakan periksa koneksi internet Anda.</h6>
                    <a href="/" class="btn btn-light btn-sm">Ulangi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
