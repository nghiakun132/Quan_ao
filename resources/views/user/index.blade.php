@extends('user.layouts.index')
@section('title', 'Trang chủ')
@section('content')
    {{-- <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="{{asset('user/img/hero-1.jpg')}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>
                                Thời trang trẻ em
                            </span>
                            <h1>Black friday</h1>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{asset('user/img/hero-2.jpg')}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Black friday</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End --> --}}

    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                @foreach ($categoryParents as $item)
                    <div class="col-lg-4">
                        <a href="{{ route('user.category.index', $item->slug) }}">
                            <div class="single-banner">
                                <img src="{{ asset(BANNER_CATEGORY[$item->id]) }}" alt="">
                                <div class="inner-text">
                                    <h4>{{ $item->name }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Banner Section End -->
    @if (count($womenProducts) > 0)
        <section class="women-banner spad">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="product-large set-bg" data-setbg="{{ asset('user/img/products/women-large.jpg') }}">
                            <h2>
                                Thời trang nữ
                            </h2>
                            <a href="{{ route('user.category.index', 'thoi-trang-nu') }}">
                                Xem thêm
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-8 offset-lg-1">
                        <div class="product-slider owl-carousel">
                            @foreach ($womenProducts as $womenProduct)
                                <div class="product-item">
                                    <a href="{{ route('user.product.index', $womenProduct->slug) }}">
                                        <div class="pi-pic">
                                            <img src="{{ $womenProduct->image }}" alt="">
                                            @if ($womenProduct->sale > 0)
                                                <div class="sale">Sale</div>
                                            @endif
                                            <div class="icon">
                                                <a href="{{ route('user.white_list.add', $womenProduct->id) }}"><i
                                                        class="icon_heart_alt"></i></a>
                                            </div>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name">
                                                {{ $womenProduct->category->name }}
                                            </div>
                                            <a href="#">
                                                <h5>
                                                    {{ $womenProduct->name }}
                                                </h5>
                                            </a>
                                            <div class="product-price">
                                                @if ($womenProduct->sale > 0)
                                                    {{ number_format($womenProduct->price - ($womenProduct->price * $womenProduct->sale) / 100) }}
                                                    <span>{{ number_format($womenProduct->price) }}</span>
                                                @else
                                                    ${{ number_format($womenProduct->price) }}
                                                @endif
                                                {{-- <span>$35.00</span> --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            {{-- <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ asset('user/img/products/women-2.jpg') }}" alt="">
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a>
                                    </li>
                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">Shoes</div>
                                <a href="#">
                                    <h5>Guangzhou sweater</h5>
                                </a>
                                <div class="product-price">
                                    $13.00
                                </div>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ asset('user/img/products/women-3.jpg') }}" alt="">
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a>
                                    </li>
                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">Towel</div>
                                <a href="#">
                                    <h5>Pure Pineapple</h5>
                                </a>
                                <div class="product-price">
                                    $34.00
                                </div>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ asset('user/img/products/women-4.jpg') }}" alt="">
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a>
                                    </li>
                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">Towel</div>
                                <a href="#">
                                    <h5>Converse Shoes</h5>
                                </a>
                                <div class="product-price">
                                    $34.00
                                </div>
                            </div>
                        </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin-->
    {{-- <section class="deal-of-week set-bg spad" data-setbg="{{ asset('user/img/time-bg.jpg') }}" data-time="04/16/2024">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Deal Of The Week</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br /> do ipsum dolor sit amet,
                        consectetur adipisicing elit </p>
                    <div class="product-price">
                        $35.00
                        <span>/ HanBag</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>7</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>3</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>3</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>3</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="#" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section> --}}
    <!-- Deal Of The Week Section End -->

    @if (count($menProducts) > 0)
        <section class="man-banner spad">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="product-slider owl-carousel">
                            @foreach ($menProducts as $menProduct)
                                <div class="product-item">
                                    <a href="{{ route('user.product.index', $menProduct->slug) }}">
                                        <div class="pi-pic">
                                            <img src="{{ $menProduct->image }}" alt="">
                                            @if ($menProduct->sale > 0)
                                                <div class="sale">Sale</div>
                                            @endif
                                            <div class="icon">
                                                <a href="{{ route('user.white_list.add', $menProduct->id) }}"
                                                    style="color: red; text-decoration: none;"><i
                                                        class="icon_heart_alt"></i></a>
                                            </div>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name">
                                                {{ $menProduct->category->name }}
                                            </div>
                                            <a href="{{ route('user.product.index', $menProduct->slug) }}">
                                                <h5>
                                                    {{ $menProduct->name }}
                                                </h5>
                                            </a>
                                            <div class="product-price">
                                                @if ($menProduct->sale > 0)
                                                    {{ number_format($menProduct->price - ($menProduct->price * $menProduct->sale) / 100) }}
                                                    <span>{{ number_format($menProduct->price) }}</span>
                                                @else
                                                    ${{ number_format($menProduct->price) }}
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="product-large set-bg m-large"
                            data-setbg="{{ asset('user/img/products/man-large.jpg') }}">
                            <h2>
                                Thời trang nam
                            </h2>
                            <a href="{{ route('user.category.index', 'thoi-trang-nam') }}">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Man Banner Section End -->

    <!-- Instagram Section Begin -->
    <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-1.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">

                    </a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-2.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#"></a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-3.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#"></a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-4.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#"></a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-5.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#"></a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('user/img/insta-6.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#"></a></h5>
            </div>
        </div>
    </div>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    {{-- <section class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{asset('user/img/latest-1.jpg')}}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    May 4,2019
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="#">
                                <h4>The Best Street Style From London Fashion Week</h4>
                            </a>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{asset('user/img/latest-2.jpg')}}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    May 4,2019
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="#">
                                <h4>Vogue's Ultimate Guide To Autumn/Winter 2019 Shoes</h4>
                            </a>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{asset('user/img/latest-3.jpg')}}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    May 4,2019
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="#">
                                <h4>How To Brighten Your Wardrobe With A Dash Of Lime</h4>
                            </a>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('user/img/icon-1.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Free Shipping</h6>
                                <p>For all order over 99$</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('user/img/icon-2.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Delivery On Time</h6>
                                <p>If good have prolems</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{asset('user/img/icon-1.png')}}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Secure Payment</h6>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Latest Blog Section End -->

    <!-- Partner Logo Section Begin -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset('user/img/logo-carousel/logo-1.png') }}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset('user/img/logo-carousel/logo-2.png') }}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset('user/img/logo-carousel/logo-3.png') }}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset('user/img/logo-carousel/logo-4.png') }}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset('user/img/logo-carousel/logo-5.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
