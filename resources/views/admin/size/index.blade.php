@extends('admin.layouts.index')
@section('title', 'Kích thước')
@section('content')
    <h3>
        Quản lý kích thước
    </h3>

    <div class="row">
        <div class="d-flex justify-content-between">
            <div>
                <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>

        <div class="col-12 mt-2">
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th style="width: 13%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sizes as $size)
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>{{ $size->name }}</td>
                            <td class="d-flex flex-column">
                                <a class="btn btn-primary mb-2" onclick="showEdit('{{ $size->id }}')">Sửa</a>
                                <a href="{{ route('admin.size.delete', $size->id) }}"
                                    class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="3">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="add-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm kích thước</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.size.store') }}" method="post" id="add-size-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tên kích thước</label>
                                    <input type="text" class="form-control" name="name" id="error-name"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-name').text('');"
                                        placeholder="Nhập tên kích thước">
                                    <p id="error-msg-name" class="text-danger">
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

    <div class="modal fade" id="edit-size">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm kích thước</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit-size-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tên kích thước</label>
                                    <input type="text" class="form-control" name="name" id="edit-error-name"
                                        oninput="$(this).removeClass('is-invalid');$('#error-edit-msg-name').text('');"
                                        placeholder="Nhập tên kích thước">
                                    <p id="error-edit-msg-name" class="text-danger">
                                </div>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">
                                Cập nhật
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
            $("#add-size-form").submit(function(e) {
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
                                text: 'Thêm mới thành công',
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

        $("#edit-size-form").submit(function(e) {
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
                        window.location.reload();
                    }
                },
                error: function(error) {
                    if (error.status === 400) {
                        let errors = error.responseJSON.errors;
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                $(`#edit-error-${key}`).addClass('is-invalid');
                                $(`#error-edit-msg-${key}`).text(errors[key][0]);
                            }
                        }

                        return
                    }

                    alert('Có lỗi xảy ra, vui lòng thử lại sau');
                }
            });
        });

        function showEdit(id) {
            $.ajax({
                url: "{{ route('admin.size.edit', ['id' => 'id']) }}".replace('id', id),
                type: 'GET',
                success: function(response) {
                    if (response.status == 200) {
                        let category = response.data;
                        $('#edit-size-form').attr('action',
                            "{{ route('admin.size.update', ['id' => 'id']) }}".replace('id', id));
                        $('#edit-size-form input[name="name"]').val(category.name);
                        $('#edit-size').modal('show');
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
    </script>


@endsection
