@if (Auth::user()->id == $id)

<a href="{{ route($route, $id) }}" class="btn btn-primary">Akun Anda</a>

@else

<a href="{{ route($route, $id) }}" class="btn btn-info btn-sm rounded-circle">
    <i class="bi bi-person-vcard"></i>
</a>
<button class="btn btn-danger btn-sm rounded-circle hapus-data" data-id="{{ $id }}" data-nama="{{ $nama }}">
    <i class=" bi bi-trash3"></i>
</button>

@endif
