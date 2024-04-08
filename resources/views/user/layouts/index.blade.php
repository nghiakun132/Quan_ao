<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cửa hàng thời trang">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title', 'Trang chủ')
    </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') }}">


</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                        Tuong@gmail.com
                    </div>
                    <div class="phone-service">
                        <i class=" fa fa-phone"></i>
                        1234553
                    </div>
                </div>
                <div class="ht-right">
                    @if (!Auth::check())
                        <a href="{{ route('user.login') }}" class="login-panel">
                            <i class="fa fa-sign-in">
                            </i>Đăng nhập</a>
                    @else
                        <a href="{{ route('user.logout') }}" class="login-panel"><i class="fa fa-sign-out"></i>Đăng
                            xuất</a>
                        <div class="top-social display-mobile">
                            <div>Xin chào, <a href="{{ route('user.profile') }}">{{ Auth::user()->name }}</a></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img src="{{ asset('user/img/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <form action="{{ route('user.search') }}">
                            <div class="advanced-search">
                                <div class="input-group">
                                    <input type="text" placeholder="Bạn muốn tìm gì?" name="keyword"
                                        value="{{ request()->keyword }}">
                                    <button type="submit"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="{{ route('user.order') }}">
                                    {{-- order --}}
                                    <i class="icon_bag_alt"></i>
                                </a>
                            </li>
                            <li class="heart-icon">
                                <a href="{{ route('user.white_list') }}">
                                    <i class="icon_heart_alt"></i>
                                    <span>
                                        {{ $count_whitelist_global }}
                                    </span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="{{ route('user.cart') }}">
                                    <i class="ti-shopping-cart"></i>
                                    <span>
                                        {{ $cart_global->count() }}
                                    </span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <th></th>
                                            <tbody>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @foreach ($cart_global as $cart)
                                                    <tr>
                                                        <td class="si-pic"><img src="{{ $cart->product->image }}"
                                                                width="80" height="80"
                                                                alt="{{ $cart->product->name }} - {{ $cart->size->name }}">
                                                        </td>
                                                        <td class="si-text">
                                                            <div class="product-selected">
                                                                <p>
                                                                    @if ($cart->product->sale > 0)
                                                                        {{ number_format(($cart->product->price * (100 - $cart->product->sale)) / 100) }}
                                                                    @else
                                                                        {{ number_format($cart->product->price) }}
                                                                    @endif
                                                                    x
                                                                    {{ $cart->quantity }}
                                                                </p>
                                                                <h6>
                                                                    {{ $cart->product->name }} -
                                                                    {{ $cart->size->name }}
                                                                </h6>
                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <i class="ti-close"></i>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $price =
                                                            $cart->product->sale > 0
                                                                ? ($cart->product->price *
                                                                        (100 - $cart->product->sale)) /
                                                                    100
                                                                : $cart->product->price;
                                                        $total += $price * $cart->quantity;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            <caption>
                                                {{ $cart_global->count() }} sản phẩm trong giỏ hàng
                                            </caption>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>Tổng tiền:</span>
                                        <h5>{{ number_format($total) }}</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="{{ route('user.cart') }}" class="primary-btn view-card">Xem giỏ
                                            hàng</a>
                                        <a href="{{ route('user.cart.checkout') }}"
                                            class="primary-btn checkout-btn">Thanh toán</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">
                                {{ number_format($total) . 'VNĐ' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class=" {{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Trang
                                chủ
                            </a></li>
                        @foreach ($categories_global as $cg)
                            @if ($cg->children->count() > 0)
                                <li class=" {{ request()->is('danh-muc/' . $cg->slug) ? 'active' : '' }}">
                                    <a href="{{ route('user.category.index', $cg->slug) }}">{{ $cg->name }}</a>
                                    <ul class="dropdown">
                                        @foreach ($cg->children as $child)
                                            <li
                                                class=" {{ request()->is('danh-muc/' . $child->slug) ? 'active' : '' }}">
                                                <a href="{{ route('user.category.index', $child->slug) }}">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class=" {{ request()->is('danh-muc/' . $cg->slug) ? 'active' : '' }}">
                                    <a href="{{ route('user.category.index', $cg->slug) }}">{{ $cg->name }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li><a href="./contact.html">Liên hệ</a></li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <div>
        @yield('content')
    </div>

    @include('user.layouts.footer')

    <script src="{{ asset('user/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
    <script src="{{ asset('user/js/cart.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @yield('extra-scripts')

    @include('user.layouts.alert')
</body>

</html>
