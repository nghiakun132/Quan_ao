@extends('admin.layouts.index')
@section('title', 'Mã giảm giá')
@section('content')
    <h3>
        Quản lý mã giảm giá
    </h3>

    <div class="row">
        <div class="d-flex justify-content-between">
            <div>
                <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>
                                Mã giảm giá
                            </th>
                            <th>
                                Giảm giá
                            </th>
                            <th>
                                Số lượng
                            </th>
                            <th>
                                Số lượng đã sử dụng
                            </th>
                            <th>
                                Ngày bắt đầu
                            </th>
                            <th>
                                Ngày kết thúc
                            </th>
                            <th style="width: 13%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $discount)
                            <tr>
                                <td>{{ $discount->id }}</td>
                                <td>{{ $discount->code }}</td>
                                <td>{{ $discount->percent }}%</td>
                                <td>{{ $discount->quantity }}</td>
                                <td>{{ $discount->discount_has_used }}</td>
                                <td>{{ $discount->start_at }}</td>
                                <td>{{ $discount->end_at }}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#edit-discount" onclick="showEdit({{ $discount->id }})">Sửa</a>
                                    <a href="javascript:void(0)" onclick="handleDelete({{ $discount->id }})"
                                        class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mã giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.discount.store') }}" method="post" id="add-discount-form">
                        @csrf
                        <div class="form-group">
                            <label for="percent">Giảm giá</label>
                            <input type="number" class="form-control" name="percent" id="error-percent"
                                placeholder="Nhập phần trăm giảm giá"
                                oninput="$(this).removeClass('is-invalid'); $('#error-msg-percent').text('')">
                            <span id="error-msg-percent" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input type="number" class="form-control" name="quantity" id="error-quantity"
                                placeholder="Nhập số lượng mã giảm giá"
                                oninput="$(this).removeClass('is-invalid'); $('#error-msg-quantity').text('')">
                            <span id="error-msg-quantity" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="start_at">Ngày bắt đầu</label>
                            <input type="date" class="form-control" name="start_at" id="error-start_at"
                                oninput="$(this).removeClass('is-invalid'); $('#error-msg-start_at').text('')">

                            <span id="error-msg-start_at" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="end_at">Ngày kết thúc</label>
                            <input type="date" class="form-control" name="end_at" id="error-end_at"
                                oninput="$(this).removeClass('is-invalid'); $('#error-msg-end_at').text('')">

                            <span id="error-msg-end_at" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-discount">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa mã giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="edit-discount-form">
                        @csrf
                        <input type="hidden" name="id" id="edit-error-id">
                        <div class="form-group">
                            <label for="code">Mã giảm giá</label>
                            <input type="text" class="form-control" name="code" id="edit-error-code"
                                placeholder="Nhập mã giảm giá" disabled />
                        </div>
                        <div class="form-group">
                            <label for="percent">Giảm giá</label>
                            <input type="number" class="form-control" name="percent" id="edit-error-percent"
                                placeholder="Nhập phần trăm giảm giá"
                                oninput="$(this).removeClass('is-invalid'); $('#error-edit-msg-percent').text('')">
                            <span id="error-edit-msg-percent" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input type="number" class="form-control" name="quantity" id="edit-error-quantity"
                                placeholder="Nhập số lượng mã giảm giá"
                                oninput="$(this).removeClass('is-invalid'); $('#error-edit-msg-quantity').text('')">
                            <span id="error-edit-msg-quantity" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="start_at">Ngày bắt đầu</label>
                            <input type="date" class="form-control" name="start_at" id="edit-error-start_at"
                                oninput="$(this).removeClass('is-invalid'); $('#error-edit-msg-start_at').text('')">

                            <span id="error-edit-msg-start_at" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="end_at">Ngày kết thúc</label>
                            <input type="date" class="form-control" name="end_at" id="edit-error-end_at"
                                oninput="$(this).removeClass('is-invalid'); $('#error-edit-msg-end_at').text('')">

                            <span id="error-edit-msg-end_at" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="edit-description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('extra-scripts')
    <script>
        $(function() {
            $(".select2").selectize();
        });

        $(document).ready(function() {
            $("#add-discount-form").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    'icon': 'info',
                    'text': 'Đang xử lý...',
                    'title': 'Đang xử lý...',
                    'showConfirmButton': false,
                    'timer': 500,
                }).then(() => {
                    let url = $(this).attr('action');
                    let data = $(this).serializeArray();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Thêm mới thành công',
                                    'showConfirmButton': false,
                                    'timer': 1000,
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(error) {
                            if (error.status === 400) {
                                let errors = error.responseJSON.errors;

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        $(`#error-${key}`).addClass('is-invalid');
                                        $(`#error-msg-${key}`).text(errors[key][0]);
                                    }
                                }

                                return
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Có lỗi xảy ra, vui lòng thử lại sau',
                            })
                        }
                    });
                });

            });
        });

        $(document).ready(function() {
            $("#edit-discount-form").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    'icon': 'info',
                    'text': 'Đang xử lý...',
                    'title': 'Đang xử lý...',
                    'showConfirmButton': false,
                    'timer': 500,
                }).then(() => {
                    let url = `{{ route('admin.discount.update', ['id' => ':id']) }}`.replace(
                        ':id',
                        $('#edit-error-id')
                        .val());
                    let data = $(this).serializeArray();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Cập nhật thành công',
                                    'showConfirmButton': false,
                                    'timer': 1000,
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(error) {
                            if (error.status === 400) {
                                let errors = error.responseJSON.errors;

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        $(`#edit-error-${key}`).addClass('is-invalid');
                                        $(`#error-edit-msg-${key}`).text(errors[key][
                                            0
                                        ]);
                                    }
                                }

                                return
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Có lỗi xảy ra, vui lòng thử lại sau',
                            })
                        }
                    });
                });
            });
        });

        async function showEdit(id) {
            Swal.fire({
                'icon': 'info',
                'text': 'Đang xử lý...',
                'title': 'Đang xử lý...',
                'showConfirmButton': false,
                'timer': 200,
            }).then(() => {
                $.ajax({
                    url: "{{ route('admin.discount.edit', ['id' => 'id']) }}".replace('id', id),
                    type: 'GET',
                    success: async function(response) {
                        if (response.status == 200) {
                            let category = response.data;

                            await Object.keys(category).forEach(async function(key) {
                                await $(`#edit-discount-form input[name=${key}]`).val(
                                    category[
                                        key]);
                                await $(
                                        `#edit-discount-form textarea[name=description]`
                                    )
                                    .val(
                                        category[
                                            'description']);
                            });
                        }
                    },
                    error: function(error) {
                        alert('Có lỗi xảy ra, vui lòng thử lại sau');
                    }
                });
            });
        }

        async function handleDelete(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa mã giảm giá này?',
                text: "Dữ liệu sẽ không thể khôi phục lại!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('admin.discount.delete', ['id' => ':id']) }}`.replace(':id',
                            id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Xóa thành công',
                                    'showConfirmButton': false,
                                    timer: 1000
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Có lỗi xảy ra, vui lòng thử lại sau',
                            })
                        }
                    });
                }
            });
        }
    </script>


@endsection
