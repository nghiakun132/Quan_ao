@extends('user.layouts.index')
@section('title', 'Chi tiết đơn hàng')
@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <a href="{{ route('user.order') }}"> Đơn hàng</a>
                        <span>
                            Chi tiết đơn hàng
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                @if ($order->status === \App\Models\Order::CANCEL)
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            Đơn hàng đã bị hủy lúc {{ $order->cancel->created_at }}
                            <div>
                                <strong>Lý do hủy:</strong> {{ $order->cancel->reason }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->details as $key => $orderDetail)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td><a href="{{ route('user.product.index', $orderDetail->product->slug) }}"
                                                class="text-primary" target="_blank">
                                                {{ $orderDetail->product->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <img src="{{ $orderDetail->product->image }}"
                                                alt="{{ $orderDetail->product->name }}" width="100">
                                        </td>
                                        <td>{{ $orderDetail->quantity }}</td>
                                        <td>{{ number_format($orderDetail->price) }}đ</td>
                                        <td>{{ number_format($orderDetail->price * $orderDetail->quantity) }}đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Không có dữ liệu</td>
                                    </tr>
                                @endforelse

                                <tr>
                                    <td colspan="4" class="text-right">Tổng tiền</td>
                                    <td colspan="2" class="text-right">{{ number_format($order->total) }} đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
