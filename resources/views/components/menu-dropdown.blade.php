<li class="menu {{ (request()->is($menuActive)) ? 'active' : '' }}">
    <a href="#{{ $menuParent }}" data-toggle="collapse" aria-expanded="{{ (request()->is($menuActive)) ? 'true' : 'false' }}" class="dropdown-toggle">
        <div>
            <i data-feather="{{ $menuIcon }}"></i>
            <span>{{ $menuTitle }}</span>
        </div>
        <div>
            <i data-feather="chevron-right"></i>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled {{ (request()->is($menuActive)) ? 'collapse show' : '' }}" id="{{ $menuParent }}" data-parent="#accordionSidebar">

        {{ $slot }}

    </ul>
</li>
