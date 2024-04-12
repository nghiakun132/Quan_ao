<ul class="nav nav-tabs">
    <li class="nav-item" id="nav-item">
        <a class="nav-link @if (request()->routeIs('user.profile')) active @endif" href="{{ route('user.profile') }}">Thông tin
            cá nhân</a>
    </li>
    <li class="nav-item" id="nav-item">
        <a class="nav-link @if (request()->routeIs('user.order')) active @endif" href="{{ route('user.order') }}">Đơn hàng của
            tôi</a>
    </li>
    <li class="nav-item" id="nav-item">
        <a class="nav-link @if (request()->routeIs('user.address')) active @endif" href="{{ route('user.address') }}">Địa
            chỉ giao hàng</a>
        </a>
    </li>
</ul>
