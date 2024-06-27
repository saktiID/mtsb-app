@extends('layout.main')
@section('title', 'Beranda')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Beranda">

    </x-card-box>

</div>
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>

@endsection
