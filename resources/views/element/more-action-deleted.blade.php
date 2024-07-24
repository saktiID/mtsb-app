<div class="dropdown d-inline-block">
    <a class="dropdown-toggle" href="#" role="button" id="dropMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="12" cy="5" r="1"></circle>
            <circle cx="12" cy="19" r="1"></circle>
        </svg>
    </a>

    <div class="dropdown-menu dropleft" aria-labelledby="dropMore" style="will-change: transform;">

        <a href="javascript:void(0);" class="dropdown-item pulihkan-data" data-id="{{ $id }}"><i class="bi bi-escape"></i> Pulihkan</a>
        <a href="javascript:void(0);" class="dropdown-item hapus-data" data-id="{{ $id }}" data-nama="{{ $nama }}"><i class=" bi bi-trash3"></i> Hapus permanen</a>
    </div>
</div>
