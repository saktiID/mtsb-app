<li class="{{ (request()->is($menuActive)) ? 'active' : '' }}">
    <a href="{{ route($menuRoute) }}">{{ $menuTitle }}</a>
</li>
