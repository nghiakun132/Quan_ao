@extends('admin.layouts.index')
@section('title', 'Chi tiết đơn hàng #' . $order->code)
@section('content')

    <?php
    use App\Models\Order;
    ?>
    <h3>
        Đơn hàng #{{ $order->code }} - {{ Order::LIST_STATUS[$order->status] }}
    </h3>

    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Tên sản phẩm
                            </th>
                            <th>
                                Hình ảnh
                            </th>
                            <th>
                                Số lượng
                            </th>
                            <th>
                                Giá
                            </th>
                            <th>
                                Thành tiền
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $key => $detail)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $detail->product->name }} - {{ $detail->size->name }}
                                    <a href="{{ route('user.product.index', $detail->product->slug) }}" target="_blank"
                                        style="color: rgb(47, 50, 244); text-decoration: none;" title="Xem chi tiết">

                                        &nbsp;&nbsp;<i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ $detail->product->image }}" alt="{{ $detail->product->name }}"
                                        style="width: 80px">
                                </td>
                                <td>
                                    {{ $detail->quantity }}
                                </td>
                                <td>
                                    {{ number_format($detail->price) }} VNĐ
                                </td>
                                <td>
                                    {{ number_format($detail->price * $detail->quantity) }} VNĐ
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
