<div class="dropdown d-inline-block">
    <a class="dropdown-toggle" href="#" role="button" id="dropMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="12" cy="5" r="1"></circle>
            <circle cx="12" cy="19" r="1"></circle>
        </svg>
    </a>

    <div class="dropdown-menu dropleft" aria-labelledby="dropMore" style="will-change: transform;">
        @if (Auth::user()->id == $id)
        <a href="{{ route($route, $id) }}" class="dropdown-item"><i class="bi bi-person-vcard"></i> Akun Anda</a>
        @else
        <a href="{{ route($route, $id) }}" class="dropdown-item"><i class="bi bi-person-vcard"></i> Lihat detail</a>
        <a href="javascript:void(0);" class="dropdown-item hapus-data" data-id="{{ $id }}" data-nama="{{ $nama }}"><i class=" bi bi-trash3"></i> Hapus data</a>
        @endif
    </div>
</div>
