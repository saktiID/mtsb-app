<li class="menu {{ (request()->routeIs($menuActive)) ? 'active' : '' }}">
    <a href="{{ route($menuRoute) }}" aria-expanded="{{ (request()->routeIs($menuActive)) ? 'true' : 'false' }}" class="dropdown-toggle">
        <div class="">
            <i data-feather="{{ $menuIcon }}"></i>
            <span> {{ $menuTitle }}</span>
        </div>
    </a>
</li>
