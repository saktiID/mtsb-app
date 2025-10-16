@if ($route == null)
    <a href="javascript:void(0)">
        <div class="avatar text-center">
            <img alt="avatar" src="{{ route('get-foto', ['filename' => $avatar]) }}" class="rounded bg-success"
                width="50px" height="50px" />
        </div>
    </a>
@else
    <a href="{{ route($route, $id) }}" class="d-flex justify-content-start align-items-center">
        <div class="avatar">
            <img alt="avatar" src="{{ route('get-foto', ['filename' => $avatar]) }}" class="rounded bg-success"
                width="50px" height="50px" />
        </div>
        <div class="ml-3">
            <p>{{ $nama_walas }}</p>
        </div>
    </a>
@endif
