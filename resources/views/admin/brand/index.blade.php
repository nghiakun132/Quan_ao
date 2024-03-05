@extends('admin.layouts.index')
@section('title', 'Quản lý nhà sản xuất')
@section('content')
    <h3>
        Quản lý nhà sản xuất
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
                            <th>Tên</th>
                            <th>
                                Email
                            </th>
                            <th>
                                Số điện thoại
                            </th>
                            <th>
                                Địa chỉ
                            </th>
                            <th style="width: 13%">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->email }}</td>
                                <td>{{ $brand->phone }}</td>
                                <td>{{ $brand->address }}</td>
                                <td class="d-flex flex-column">
                                    <a href="{{ route('admin.brand.edit', $brand->id) }}"
                                        class="btn btn-primary mb-2">Sửa</a>
                                    <a href="{{ route('admin.brand.delete', $brand->id) }}" class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm nhà sản xuất</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.brand.store') }}" method="post" id="add-brand-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="error-name">Tên nhà sản xuất</label>
                                    <input type="text" class="form-control" name="name" id="error-name"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-name').text('');"
                                        placeholder="Nhập tên nhà sản xuất">
                                    <p id="error-msg-name" class="text-danger">
                                </div>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="error-email">Email</label>
                                    <input type="text" class="form-control" name="email" id="error-email"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-email').text('');"
                                        placeholder="Nhập email">
                                    <p id="error-msg-email" class="text-danger">
                                </div>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="error-phone">Số điện thoại</label>
                                    <input type="number" class="form-control" name="phone" id="error-phone"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-phone').text('');"
                                        placeholder="Nhập số điện thoại">
                                    <p id="error-msg-phone" class="text-danger">
                                </div>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="error-address">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" id="error-address"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-address').text('');"
                                        placeholder="Nhập địa chỉ">
                                    <p id="error-msg-address" class="text-danger">
                                </div>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">
                                Thêm mới
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            $("#add-brand-form").submit(function(e) {
                console.log('scas');
                e.preventDefault();
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
                                text: response.message,
                            }).then(() => {
                                window.location.reload();
                            })
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
                            text: 'Có lỗi xảy ra!',
                        })
                    }
                });
            });
        });
    </script>


@endsection
