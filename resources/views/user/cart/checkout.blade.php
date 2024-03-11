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
            <form action="#" class="checkout-form">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>
                            Thông tin thanh toán
                        </h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="last">Tên<span>*</span></label>
                                <input type="text" name="name" id="name">
                            </div>
                            <div class="col-lg-12">
                                <label for="last">Số điện thoại<span>*</span></label>
                                <input type="text" name="phone" id="phone">
                            </div>
                            <div class="col-lg-4">
                                <label for="cun">Tỉnh<span>*</span></label>
                                <select class="custom-select" id="province" name="province">
                                    <option>Chọn tỉnh</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="street">Quận/ Huyện<span>*</span></label>
                                <select class="custom-select" id="district" name="district">
                                    <option>Chọn quận/ huyện</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="cun-name">Phường/ Xã</label>
                                <select class="custom-select" id="ward" name="ward">
                                    <option>Chọn phường/ xã</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>
                                    <li class="fw-normal">Combination x 1 <span>$60.00</span></li>
                                    <li class="fw-normal">Combination x 1 <span>$60.00</span></li>
                                    <li class="fw-normal">Combination x 1 <span>$120.00</span></li>
                                    <li class="fw-normal">Subtotal <span>$240.00</span></li>
                                    <li class="total-price">Total <span>$240.00</span></li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Cheque Payment
                                            <input type="checkbox" id="pc-check">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Paypal
                                            <input type="checkbox" id="pc-paypal">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-btn">Place Order</button>
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
        $(document).ready(function() {
            $.ajax({
                url: `{{ route('api.provinces') }}`,
                method: 'GET',
                success: async function(response) {
                    await response.forEach(function(province, key) {
                        $('#province').append(
                            `<option value="${province.id}">${province.name}</option>`);
                    });
                }
            });

            $('#province').change(function() {
                var province = $(this).val();
                $.ajax({
                    url: `{{ route('api.districts', ['provinceId' => 'provinceId']) }}`.replace(
                        'provinceId', province),
                    method: 'GET',
                    success: function(response) {
                        $('#district').empty();
                        $('#district').append(`<option value="">Chọn quận/ huyện</option>`);
                        response.forEach(function(district, key) {
                            $('#district').append(
                                `<option value="${district.id}">${district.name}</option>`
                            );
                        });
                    }
                });
            });

            $('#district').change(function() {
                var province = $('#province').val();
                var district = $(this).val();
                $.ajax({
                    url: `{{ route('api.wards', ['districtId' => 'districtId']) }}`.replace(
                        'districtId', district),
                    method: 'GET',
                    success: function(response) {
                        $('#ward').empty();
                        $('#ward').append(`<option value="">Chọn phường/ xã</option>`);
                        response.forEach(function(ward, key) {
                            $('#ward').append(
                                `<option value="${ward.id}">${ward.name}</option>`
                            );
                        });
                    }
                });
            });
        });
    </script>
@endsection
