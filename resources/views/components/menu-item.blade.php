<li class="menu {{ (request()->routeIs($menuActive)) ? 'active' : '' }}@if(isset($altActive))
{{ (request()->is($altActive)) ? 'active' : '' }}    
@endif">
    <a href="{{ route($menuRoute) }}" aria-expanded="{{ (request()->routeIs($menuActive)) ? 'true' : '' }}@if(isset($altActive)){{ (request()->is($altActive)) ? 'true' : '' }}@endif" class="dropdown-toggle">
        <div class="">
            <i data-feather="{{ $menuIcon }}"></i>
            <span> {{ $menuTitle }}</span>
        </div>
    </a>
</li>
