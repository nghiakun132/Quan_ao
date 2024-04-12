@extends('user.layouts.index')
@section('title', 'Quản lý địa chỉ giao hàng')

@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>
                            Quản lý địa chỉ giao hàng
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="d-flex justify-content-between">
                        @include('user.nav')
                        <a class="btn btn-outline-success" href="#" data-toggle="modal"
                            data-target="#add-address">Thêm mới</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên người nhận</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($addresses as $key => $address)
                                    <tr @if ($address->is_default == 1) style="background-color: #f9bcbc;" @endif>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $address->name }}</td>
                                        <td>{{ $address->phone }}</td>
                                        <td>{{ $address->full_address }}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary">Sửa</a>
                                            <a href="{{ route('user.address.delete', $address->id) }}"
                                                class="btn btn-danger">Xóa</a>
                                            <a href="{{ route('user.address.default', $address->id) }}"
                                                class="btn btn-success">Mặc định</a>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="add-address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('user.address.store') }}" method="post" class="checkout-form">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="name">Tên<span>*</span></label>
                                <input type="text" name="name" id="name">
                            </div>
                            <div class="col-lg-12">
                                <label for="phone">Số điện thoại<span>*</span></label>
                                <input type="text" name="phone" id="phone">
                            </div>
                            <div class="col-lg-12">
                                <label for="province">Tỉnh<span>*</span></label>
                                <select class="custom-select" id="province" name="province">
                                    <option value="">Chọn tỉnh/ thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['id'] }}">
                                            {{ $province['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="district">Quận/ Huyện<span>*</span></label>
                                <select class="custom-select" id="district" name="district">
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="ward">Phường/ Xã</label>
                                <select class="custom-select" id="ward" name="ward">
                                    <option value="">Chọn phường/ xã</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="address">Địa chỉ cụ thể<span>*</span></label>
                                <input type="text" name="address" id="address">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')
    <script>
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
    </script>
@endsection
