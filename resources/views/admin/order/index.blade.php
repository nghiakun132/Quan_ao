@extends('admin.layouts.index')
@section('title', 'Đơn hàng')
@section('content')

    <?php
    use App\Models\Order;
    ?>
    <h3>
        Đơn hàng
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
                                Tên khách hàng
                            </th>
                            <th>
                                Số điện thoại
                            </th>
                            <th>
                                Địa chỉ
                            </th>
                            <th>
                                Tổng tiền
                            </th>
                            <th>
                                Trạng thái
                            </th>
                            <th>
                                Thời gian
                            </th>
                            <th>
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{ $order->code }}
                                </td>
                                <td>
                                    {{ $order->orderAddress->name }}
                                </td>
                                <td>
                                    {{ $order->orderAddress->phone }}
                                </td>
                                <td>
                                    {{ $order->orderAddress->order_address }}
                                </td>
                                <td>
                                    {{ number_format($order->total) }} VNĐ
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->getStatusClass($order->status) }}">
                                        {{ $order->getStatus($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.order.show', $order->id) }}">
                                            <span class="badge badge-info">
                                                Xem chi tiết
                                            </span>
                                        </a>
                                        @if ($order->status !== Order::CANCEL)
                                            <a onclick="handleChangeStatusOrder({{ $order->id }}, {{ $order->status }})">
                                                <span class="badge badge-success">
                                                    Xử lý
                                                </span>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        async function handleChangeStatusOrder(id, status) {
            Swal.fire({
                input: "select",
                'title': 'Thay đổi trạng thái đơn hàng',
                inputOptions: orderList[status],
                inputPlaceholder: "Chọn trạng thái đơn hàng",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
                cancelButtonText: "Hủy",
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value === "") {
                            resolve("Vui lòng chọn trạng thái");
                        } else {
                            resolve();
                        }
                    });
                },
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const status = result.value;

                    $.ajax({
                        url: `{{ route('admin.order.updateStatus', ['id' => 'ids']) }}`.replace(
                            'ids', id),
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        headers: {
                            'X-CSRF-TOKEN': `{{ csrf_token() }}`
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thay đổi trạng thái đơn hàng thành công',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thay đổi trạng thái đơn hàng thất bại',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Thay đổi trạng thái đơn hàng thất bại',
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    });
                }
            });
        }

        let demo = @json(\App\Models\Order::getStatuses())

        let orderList = JSON.parse(demo)
    </script>
@endsection
