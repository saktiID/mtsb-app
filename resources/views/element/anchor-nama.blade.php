<a href="{{ route($route, $id) }}">
    {{ $nama }}
    @if ($role == 'Admin')
    <span class="badge badge-warning">Admin</span>
    @endif
</a>
