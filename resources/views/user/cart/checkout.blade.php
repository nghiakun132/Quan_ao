@extends('user.layouts.index')
@section('title', 'Thanh toán')
@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Thanh toán</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="{{ route('user.cart.checkout.post') }}" class="checkout-form" id="checkout-form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <h4>
                            Thông tin thanh toán
                        </h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="name">Tên<span>*</span></label>
                                <input type="text" name="name" id="name" value="{{ $address->name ?? '' }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="phone">Số điện thoại<span>*</span></label>
                                <input type="text" name="phone" id="phone" value="{{ $address->phone ?? '' }}">
                            </div>
                            <div class="col-lg-4">
                                <label for="province">Tỉnh<span>*</span></label>
                                <select class="custom-select" id="province" name="province">
                                    <option value="">Chọn tỉnh/ thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['id'] }}"
                                            @if (!empty($address) && $address->province == $province['id']) selected @endif>
                                            {{ $province['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="district">Quận/ Huyện<span>*</span></label>
                                <select class="custom-select" id="district" name="district">
                                    <option value="">Chọn quận/ huyện</option>
                                    @if (!empty($address) && !empty($address->district))
                                        @foreach ($districts as $district)
                                            <option value="{{ $district['id'] }}"
                                                @if (!empty($address) && $address->district == $district['id']) selected @endif>
                                                {{ $district['name'] }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="ward">Phường/ Xã</label>
                                <select class="custom-select" id="ward" name="ward">
                                    <option value="">Chọn phường/ xã</option>
                                    @if (!empty($address) && !empty($address->ward))
                                        @foreach ($wards as $ward)
                                            <option value="{{ $ward['id'] }}"
                                                @if (!empty($address) && $address->ward == $ward['id']) selected @endif>
                                                {{ $ward['name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="address">Địa chỉ cụ thể<span>*</span></label>
                                <input type="text" name="address" id="address" value="{{ $address->address ?? '' }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="note">Ghi chú</label>
                                <textarea name="note" id="note" cols="30" rows="5" class="form-control">{{ $address->note ?? '' }}
                                </textarea>
                            </div>

                            <div class="col-lg-12">
                                <label for="save_address">Lưu thông tin địa chỉ</label>
                                <input type="checkbox" id="save_address" name="save_address" style="height: 20px" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="place-order">
                            <h4>Đơn hàng của bạn</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Tên <span>Tổng tiền</span></li>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($carts as $cart)
                                        <?php
                                        $price = $cart->product->sale > 0 ? $cart->product->price - ($cart->product->price * $cart->product->sale) / 100 : $cart->product->price;
                                        ?>
                                        <li class="fw-normal">
                                            {{ $cart->product->name }} ({{ $cart->size->name }}) x {{ $cart->quantity }}
                                            <span>{{ number_format($price * $cart->quantity) }}đ
                                            </span>
                                        </li>
                                        @php
                                            $total += $price * $cart->quantity;
                                        @endphp
                                    @endforeach

                                    @if (session('discount_value'))
                                        <li class="total-price">Giảm giá <span>{{ session('discount_value') }}%</span></li>

                                        <li class="total-price">
                                            Số tiền được giảm
                                            <span>{{ number_format(($total * session('discount_value')) / 100) }}đ</span>
                                        </li>

                                        @php
                                            $total = $total - ($total * session('discount_value')) / 100;
                                        @endphp
                                    @endif

                                    <li class="total-price">Tổng tiền <span>{{ number_format($total) }}đ</span></li>
                                </ul>
                                <div class="order-btn">
                                    <button type="button" onclick="submitOrder(event)" class="site-btn place-btn">Đặt
                                        hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('extra-scripts')
    <script>
        function submitOrder(e) {
            e.preventDefault();

            let total = '{{ count($carts) }}';

            if (total == 0) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Giỏ hàng của bạn đang trống!',
                });
            }

            var name = $('#name').val();
            var phone = $('#phone').val();
            var province = $('#province').val();
            var district = $('#district').val();
            var ward = $('#ward').val();
            var address = $('#address').val();

            if (name == '' || phone == '' || province == '' || district == '' || ward == '' || address == '') {
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Vui lòng nhập đầy đủ thông tin!',
                });
            }

            $("#checkout-form").submit();

        }

        $('#province').change(function() {
            var province = $(this).val();
            $.ajax({
                url: `{{ route('api.districts', ['provinceId' => 'provinceId']) }}`.replace(
                    'provinceId', province),
                method: 'GET',
                success: function(response) {
                    $('#district').empty();
                    $('#district').append(`<option value="">Chọn quận/ huyện</option>`);

                    let districtId = '{{ $address->district ?? '' }}';

                    response.forEach(function(district, key) {
                        $('#district').append(
                            `<option value="${district.id}"
                            ${districtId == district.id ? 'selected' : ''}>${district.name}</option>`
                        );
                    });
                }
            });
        });

        $('#district').change(function() {
            var district = $(this).val();
            $.ajax({
                url: `{{ route('api.wards', ['districtId' => 'districtId']) }}`.replace(
                    'districtId', district),
                method: 'GET',
                success: function(response) {
                    $('#ward').empty();
                    $('#ward').append(`<option value="">Chọn phường/ xã</option>`);

                    let wardId = '{{ $address->ward ?? '' }}';

                    response.forEach(function(ward, key) {
                        $('#ward').append(
                            `<option value="${ward.id}"
                            ${wardId == ward.id ? 'selected' : ''}
                            >${ward.name}</option>`
                        );
                    });
                }
            });
        });
        // });
    </script>
@endsection
