<div class="dropdown d-inline-block">
    <a class="dropdown-toggle" href="#" role="button" id="dropMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-three-dots-vertical" style="font-size: 1.4rem;"></i>
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
