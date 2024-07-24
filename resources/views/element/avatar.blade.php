@if($route == null)
<a href="javascript:void(0)">
    <div class="avatar text-center">
        <img alt="avatar" src="{{ route('get-foto', ['filename' => $avatar]) }}" class="rounded bg-success" width="50px" height="50px" />
    </div>
</a>
@else
<a href="{{ route( $route, $id) }}">
    <div class="avatar text-center">
        <img alt="avatar" src="{{ route('get-foto', ['filename' => $avatar]) }}" class="rounded bg-success" width="50px" height="50px" />
    </div>
</a>
@endif
