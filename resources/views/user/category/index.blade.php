@extends('user.layouts.index')
@section('title', 'Category')
@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>{{ $category->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Brand</h4>
                        <div class="fw-brand-check">
                            @foreach ($brands as $brand)
                                <div class="bc-item">
                                    <label for="bc-calvin">
                                        {{ $brand->name }}
                                        <input type="checkbox" id="bc-calvin" name="brand[]" value="{{ $brand->id }}"
                                            @if (request()->brand && in_array($brand->id, explode(',', request()->brand))) checked @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount" value="{{ request()->gia_tu }}">
                                    <input type="text" id="maxamount" value="{{ request()->gia_den }}">
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal
                             ui-widget ui-widget-content"
                                data-min="100000" data-max="10000000">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                        </div>
                        <a onclick="onFilter()" class="filter-btn">Filter</a>
                        <a href="{{ route('user.category.index', $category->slug) }}" class="reset-btn">Reset</a>
                    </div>

                    <div class="filter-widget">
                        <h4 class="fw-title">Size</h4>
                        <div class="fw-size-choose">
                            @foreach ($sizes as $size)
                                <div class="sc-item">
                                    <a
                                        href="@if (request()->size == $size->slug) {{ request()->fullUrlWithQuery(['size' => '']) }}
                                    @else
                                    {{ request()->fullUrlWithQuery(['size' => $size->slug]) }} @endif">
                                        <label for="{{ $size->slug }}-size"
                                            class="{{ request()->size == $size->slug ? 'active' : '' }}">
                                            {{ $size->name }}
                                        </label>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="filter-widget">
                        <h4 class="fw-title">Tags</h4>
                        <div class="fw-tags">
                            <a href="#">Towel</a>
                            <a href="#">Shoes</a>
                            <a href="#">Coat</a>
                            <a href="#">Dresses</a>
                            <a href="#">Trousers</a>
                            <a href="#">Men's hats</a>
                            <a href="#">Backpack</a>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option" style="width:100%">
                                    <select class="sorting" name="sort" id="sort"
                                        onchange="sortProduct(this.value)">
                                        <option value="{{ request()->fullUrlWithQuery(['sort' => '']) }}"
                                            @if (request()->sort == '') selected @endif>
                                            Sắp xếp theo:
                                        </option>

                                        @foreach (LIST_SORT as $key => $sort)
                                            <option value="{{ request()->fullUrlWithQuery(['sort' => $key]) }}"
                                                @if (request()->sort == $key) selected @endif>
                                                {{ $sort }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select class="p-show" name="p-show" id="p-show" onchange="showPaging(this.value)">
                                        <option value="" @if (request()->per_page == '') selected @endif>Hiển thị:
                                        </option>
                                        @foreach (LIST_PER_PAGE as $perPage)
                                            <option value="{{ $perPage }}"
                                                @if (request()->per_page == $perPage) selected @endif>{{ $perPage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>
                                    Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trong
                                    {{ $products->total() }} sản phẩm
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @forelse ($products as $product)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <a href="{{route('user.product.index', $product->slug)}}">
                                                <div class="product-image">
                                                    <img src="{{ $product->image }}" alt="">
                                                </div>
                                            </a>
                                            {{-- <div class="sale pp-sale">Sale</div> --}}
                                            <div class="icon">
                                                <i class="icon_heart_alt"></i>
                                            </div>
                                            <ul>
                                                @auth

                                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a>
                                                </li>
                                                @endauth
                                                {{-- <li class="quick-view"><a href="#">+ Xê</a></li> --}}
                                                {{-- <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a> --}}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pi-text">
                                            {{-- <div class="catagory-name">Towel</div> --}}
                                            <a href="{{route('user.product.index', $product->slug)}}">
                                                <h5>{{ $product->name }}</h5>
                                            </a>
                                            <div class="product-price">
                                                {{ number_format($product->price) }}
                                                {{-- <span>$35.00</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12">
                                    <h3>Không có sản phẩm nào</h3>
                                </div>
                            @endforelse

                            {{-- <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-2.jpg') }}" alt="">
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
                                        <div class="catagory-name">Coat</div>
                                        <a href="#">
                                            <h5>Guangzhou sweater</h5>
                                        </a>
                                        <div class="product-price">
                                            $13.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-3.jpg') }}" alt="">
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
                                            $34.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-4.jpg') }}" alt="">
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
                                        <div class="catagory-name">Coat</div>
                                        <a href="#">
                                            <h5>Microfiber Wool Scarf</h5>
                                        </a>
                                        <div class="product-price">
                                            $64.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-5.jpg') }}" alt="">
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
                                            <h5>Men's Painted Hat</h5>
                                        </a>
                                        <div class="product-price">
                                            $44.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-6.jpg') }}" alt="">
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
                                            <h5>Converse Shoes</h5>
                                        </a>
                                        <div class="product-price">
                                            $34.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-7.jpg') }}" alt="">
                                        <div class="sale pp-sale">Sale</div>
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
                                            $64.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-8.jpg') }}" alt="">
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
                                        <div class="catagory-name">Coat</div>
                                        <a href="#">
                                            <h5>2 Layer Windbreaker</h5>
                                        </a>
                                        <div class="product-price">
                                            $44.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('user/img/products/product-9.jpg') }}" alt="">
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
                                            <h5>Converse Shoes</h5>
                                        </a>
                                        <div class="product-price">
                                            $34.00
                                            <span>$35.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="loading-more">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-script')
    <script>
        function showPaging(value) {
            window.location.href = `{{ route('user.category.index', $category->slug) }}?per_page=${value}`
        }

        function sortProduct(value) {
            window.location.href = value
        }

        function onFilter() {
            // console.log($("#minamount").val());
            // console.log($("#maxamount").val());

            let brand = $("input[name='brand[]']:checked").map(function() {
                return $(this).val();
            }).get();

            let minamount = $("#minamount").val();
            let maxamount = $("#maxamount").val();

            window.location.href = `{{ route('user.category.index', $category->slug) }}?brand=${brand.join(',')}` +
                `&gia_tu=${minamount}&gia_den=${maxamount}`


        }
    </script>
