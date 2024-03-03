<nav class="mt-2" aria-label="Main Navigation">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach (config('nav') as $nav)
            @if (isset($nav['children']))
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
                        <i class="nav-icon {{ $nav['icon'] }}"></i>
                        <p>
                            {{ $nav['name'] }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($nav['children'] as $child)
                            <li class="nav-item">
                                <a href="{{ route($child['route'])}}"
                                    class="nav-link {{ request()->routeIs($child['route']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $child['name'] }}</p>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route($nav['route']) }}"
                        class="nav-link
                {{ request()->routeIs($nav['route']) ? 'active' : '' }}">

                        <i class="nav-icon {{ $nav['icon'] }}"></i>
                        <p>
                            {{ $nav['name'] }}
                        </p>
                    </a>
                </li>
            @endif
        @endforeach

    </ul>
</nav>
