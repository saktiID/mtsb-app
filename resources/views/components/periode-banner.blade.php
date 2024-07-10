<div class="col-xl-12 col-lg-12 col-md-12 col-12">
    <div class="alert alert-gradient d-flex justify-content-between align-items-center">
        <span>Periode aktif saat ini: <strong>Semester {{ $semester }} Tahun Ajaran {{ $tahunAjaran }}</strong></span>
        @if(Auth::user()->role == 'Admin')
        <a href="{{ route('data-periode') }}" class="btn btn-warning btn-small mr-0">Pindah periode</a>
        @endif
    </div>
</div>
