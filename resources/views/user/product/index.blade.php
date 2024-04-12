@extends('user.layouts.index')
@section('title', $product->name)
@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                        <a href="{{ route('user.category.index', $product->category->slug) }}">
                            {{ $product->category->name }}
                        </a>
                        <span>
                            {{ $product->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <input type="hidden" id="product_id" value="{{ $product->id }}">
                <input type="hidden" id="user_id" value="{{ auth()->id() }}">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                @foreach ($product->images as $image)
                                    <img class="product-big-img" src="{{ $image->path }}" alt="">
                                    <div class="zoom-icon">
                                        <i class="fa fa-search-plus"></i>
                                    </div>

                                    @php
                                        break;
                                    @endphp
                                @endforeach
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @foreach ($product->images as $image)
                                        <div class="pt" data-imgbigurl="{{ $image->path }}"><img
                                                src="{{ $image->path }}" alt=""></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span>oranges</span>
                                    <h3>{{ $product->name }}</h3>
                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                </div>
                                <div class="pd-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(5)</span>
                                </div>
                                <div class="pd-desc">
                                    <p>{!! $product->description !!}</p>
                                    <h4><span style="text-decoration: underline">Giá bán:</span>
                                        {{ number_format($product->sale_price) }}
                                        đ
                                        @if ($product->sale > 0)
                                            <span>
                                                {{ number_format($product->price) }} đ
                                            </span>
                                        @endif
                                    </h4>
                                </div>
                                <div class="mb-2">
                                    <label for="size">Size</label>
                                    <select name="size" id="size" class="form-control">
                                        <option value="">Chọn size</option>
                                        @foreach ($product->size as $size)
                                            <option value="{{ $size->id }}"
                                                @if ($size->pivot->quantity == 0) disabled @endif>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" name="quantity" id="quantity">
                                    </div>
                                    <a id="add-to-cart-btn" onclick="addToCart()" class=" primary-btn pd-cart">Add To
                                        Cart</a>
                                </div>
                                <ul class="pd-tags">
                                    <li><span>Danh mục</span>:
                                        <a href="{{ route('user.category.index', $product->category->slug) }}"
                                            class="text-capitalize" style="color: red">
                                            {{ $product->category->name }}
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">Mô tả</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">
                                        Thông tin chi tiết
                                    </a>
                                </li>
                                {{-- <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">
                                        Đánh giá (2)
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5>Mô tả</h5>
                                                <p>{!! $product->description !!}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            {{-- <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <span>(5)</span>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td class="p-catagory">Giá</td>
                                                <td>
                                                    <div class="p-price">
                                                        {{ number_format(($product->price * (100 - $product->sale)) / 100) }}đ


                                                        @if ($product->sale != 0)
                                                            <code style="text-decoration: line-through">
                                                                {{ number_format($product->price) }}
                                                                đ
                                                            </code>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">
                                                    Số lượng
                                                </td>
                                                <td>
                                                    <div class="p-stock">
                                                        <ul class="lisr-group">
                                                            @foreach ($product->size as $size)
                                                                <li class="list-group-item">
                                                                    <span>{{ $size->name }}</span>:
                                                                    <span>{{ $size->pivot->quantity != 0 ? $size->pivot->quantity : 'Hết hàng' }}</span>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>2 Comments</h4>
                                        <div class="comment-option">
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="img/product-single/avatar-1.png" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Brandon Kelley <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="img/product-single/avatar-2.png" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Roy Banks <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="personal-rating">
                                            <h6>Your Ratind</h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </div>
                                        <div class="leave-comment">
                                            <h4>Leave A Comment</h4>
                                            <form action="#" class="comment-form">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Name">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Email">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <textarea placeholder="Messages"></textarea>
                                                        <button type="submit" class="site-btn">Send message</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
