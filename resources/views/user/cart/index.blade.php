@extends('user.layouts.index')
@section('title', 'Giỏ hàng')
@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th class="p-name">Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th><a href="{{ route('user.cart.clean') }}" class="btn-remove">
                                            <i class="ti-close"></i></th></a>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subTotal = 0;
                                    $total = 0;
                                @endphp
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td class="cart-pic first-row">
                                            <img src="{{ $cart->product->image }}" height="100px" width="100px"
                                                alt="{{ $cart->product->name }}">
                                        </td>
                                        <td class="cart-title first-row">
                                            <a href="{{ route('user.product.index', $cart->product->slug) }}">
                                                <h5>{{ $cart->product->name }} - {{ $cart->size->name }}</h5>
                                            </a>
                                        </td>
                                        <td class="p-price first-row">{{ number_format($cart->product->price) }}</td>
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $cart->quantity }}" class="quantity-input"
                                                        data-id="{{ $cart->id }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-price first-row">
                                            {{ number_format($cart->product->price * $cart->quantity) }}
                                        </td>
                                        <td class="close-td first-row">
                                            <a href="{{ route('user.cart.remove', $cart->id) }}" class="btn-remove"><i
                                                    class="ti-close"></i></a>
                                        </td>
                                    </tr>

                                    @php
                                        $total += $cart->product->price * $cart->quantity;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="6">Không có sản phẩm nào trong giỏ hàng</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="cart-buttons">
                                <a href="{{ route('home') }}" class="primary-btn continue-shop">Tiếp tục mua hàng</a>
                                <a class="primary-btn up-cart"
                                    @if (count($carts) == 0) disabled @else
                                    onclick="updateCart()" @endif>
                                    Cập nhật giỏ hàng
                                </a>
                            </div>
                            <div class="discount-coupon">
                                <h6>Mã giảm giá</h6>
                                <form action="#" class="coupon-form" method="post">
                                    @csrf
                                    <input type="text" placeholder="Enter your codes" name="coupon" />
                                    <button type="submit" class="site-btn coupon-btn">
                                        Áp dụng
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-3">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Tạm tính <span>{{ number_format($total) }}</span></li>
                                    <li class="cart-total">Tổng tiền <span>{{ number_format($total) }}</span></li>
                                </ul>
                                <a href="{{route('user.cart.checkout')}}" class="proceed-btn">Thanh toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('extra-scripts')
<script>
    function updateCart() {
        let quantities = $('.quantity-input');
        let cart = [];
        $.each(quantities, function (index, quantity) {
            cart.push({
                id: $(this).data('id'),
                quantity: $(this).val()
            });
        });

        $.ajax({
            url: "{{ route('user.cart.update') }}",
            method: "POST",
            data: {
                cart: cart,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Cập nhật giỏ hàng thành công!',
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    }
</script>
@endsection
