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
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt hàng</th>
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

                                        <td>{{ number_format($order->total) }} VNĐ</td>
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
                                                    <a href="{{ route('user.order.cancel', $order->code) }}">
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
