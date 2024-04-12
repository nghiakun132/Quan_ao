@extends('user.layouts.index')
@section('title', 'Quản lý đơn hàng')

@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>
                            Quản lý đơn hàng
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
                    @include('user.nav')
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt hàng</th>
                                    <th scope="col">
                                        Giảm giá
                                    </th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ghi chú</th>
                                    <th scope="col">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $key => $order)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $order->code }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if ($order->discount > 0)
                                                {{ number_format($order->discount) }}đ
                                            @else
                                                0đ
                                            @endif
                                        </td>

                                        <td>{{ number_format($order->total) }}đ</td>
                                        <td>
                                            @if ($order->status == 0)
                                                <span class="badge badge-warning">Chờ xác nhận</span>
                                            @elseif ($order->status == 1)
                                                <span class="badge badge-primary">Đã xác nhận</span>
                                            @elseif ($order->status == 2)
                                                <span class="badge badge-success">Đã giao hàng</span>
                                            @else
                                                <span class="badge badge-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->note }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">

                                                <a href="{{ route('user.order.show', $order->code) }}" target="_blank">
                                                    <span class="badge badge-info">Xem chi tiết</span>
                                                </a>

                                                @if ($order->status == 0)
                                                    <a onclick="cancelOrder('{{ $order->code }}')">
                                                        <span class="badge badge-danger">Hủy đơn hàng</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Không có đơn hàng nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-scripts')

    <script>
        async function cancelOrder(code) {
            const options = {
                '1': 'Không còn nhu cầu mua hàng',
                '2': 'Không thích sản phẩm',
                '3': 'Không đúng sản phẩm',
                '4': 'Không thể giao hàng',
                '5': 'Sản phẩm lỗi',
                '6': 'Khác'
            }

            const {
                value: reason
            } = await Swal.fire({
                'input': 'select',
                'inputLabel': 'Lý do hủy đơn hàng',
                'inputOptions': options,
                'inputPlaceholder': 'Chọn lý do hủy đơn hàng',
                'showCancelButton': true,
                'confirmButtonText': 'Hủy đơn hàng',
                'showLoaderOnConfirm': true,
                'inputValidator': (value) => {
                    if (!value) {
                        return 'Vui lòng chọn lý do hủy đơn hàng'
                    }
                }
            })

            if (reason == 5) {
                const {
                    value: customReason
                } = await Swal.fire({
                    'input': 'textarea',
                    'inputLabel': 'Lý do hủy đơn hàng',
                    'inputPlaceholder': 'Nhập lý do hủy đơn hàng',
                    'showCancelButton': true,
                    'confirmButtonText': 'Hủy đơn hàng',
                    'showLoaderOnConfirm': true,
                    'inputValidator': (value) => {
                        if (!value) {
                            return 'Vui lòng nhập lý do hủy đơn hàng'
                        }
                    }
                })

                if (customReason) {
                    Swal.fire({
                        'title': 'Đang xử lý',
                        'text': 'Vui lòng chờ...',
                        'timer': 1500,
                        'showConfirmButton': false,
                    }).then(() => {
                        callAjax('{{ route('user.order.cancel') }}', 'POST', {
                            'reason': customReason,
                            'code': code,
                        })
                    })

                }
            } else if (reason) {
                Swal.fire({
                    'title': 'Đang xử lý',
                    'text': 'Vui lòng chờ...',
                    'timer': 1500,
                    'showConfirmButton': false,
                }).then(() => {
                    callAjax('{{ route('user.order.cancel') }}', 'POST', {
                        'reason': options[reason],
                        'code': code,
                    })
                })
            }
        }

        async function callAjax(url, method, data) {
            $.ajax({
                url: url,
                method: method,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            'title': 'Hủy đơn hàng thành công',
                            'icon': 'success',
                            'showConfirmButton': false,
                            'timer': 1500
                        }).then(() => {
                            window.location.reload()
                        })
                    } else {
                        Swal.fire({
                            'title': 'Hủy đơn hàng thất bại',
                            'icon': 'error',
                            'showConfirmButton': false,
                            'text': response.message,
                            'timer': 1500
                        })
                    }


                },
                error: function(error) {
                    Swal.fire({
                        'title': 'Hủy đơn hàng thất bại',
                        'icon': 'error',
                        'showConfirmButton': false,
                        'timer': 1500
                    })
                }
            })
        }
    </script>
@endsection
