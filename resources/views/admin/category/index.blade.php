@extends('admin.layouts.index')
@section('title', 'Danh mục sản phẩm')
@section('content')
    <h3>
        Quản lý danh mục sản phẩm
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
                            <th>Tên danh mục</th>
                            <th>
                                Danh mục cha
                            </th>
                            <th style="width: 13%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent->name }}</td>
                                <td class="d-flex flex-column">
                                    <a class="btn btn-primary m-2" onclick="showEdit('{{ $category->id }}')">Sửa</a>
                                    <a href="{{ route('admin.category.delete', $category->id) }}"
                                        class="btn btn-danger m-2">Xóa</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">Không có dữ liệu</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.category.store') }}" method="post" id="add-category-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" class="form-control" name="name" id="error-name"
                                        oninput="$(this).removeClass('is-invalid');$('#error-msg-name').text('');"
                                        placeholder="Nhập tên danh mục">
                                    <p id="error-msg-name" class="text-danger">
                                </div>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-select">
                                    <label for="">Danh mục cha</label>
                                    <select id="select-gear" class="select2 " placeholder="Chọn danh mục cha"
                                        name="parent_id">
                                        <option value="">--Chọn danh mục cha--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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

    <div class="modal fade" id="edit-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit-category-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" class="form-control" name="name" id="edit-error-name"
                                        oninput="$(this).removeClass('is-invalid');$('#error-edit-msg-name').text('');"
                                        placeholder="Nhập tên danh mục">
                                    <p id="error-edit-msg-name" class="text-danger">
                                </div>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-select">
                                    <label for="">Danh mục cha</label>
                                    <select name="parent_id" class="form-control" id="edit-parent_id">
                                        <option value="0">--Chọn danh mục cha--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
        $(function() {
            $(".select2").selectize();
        });
        $(document).ready(function() {
            $("#add-category-form").submit(function(e) {
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

        $("#edit-category-form").submit(function(e) {
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
                            text: 'Cập nhật thành công',
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
                                $(`#error-edit-msg-${key}`).text(errors[key][0]);
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

        function showEdit(id) {
            $.ajax({
                url: "{{ route('admin.category.edit', ['id' => 'id']) }}".replace('id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        let category = response.data;
                        $('#edit-category-form').attr('action',
                            "{{ route('admin.category.update', ['id' => 'id']) }}".replace('id', id));
                        $('#edit-category-form input[name="name"]').val(category.name);
                        $('#edit-parent_id').val(category.parent_id);
                        $('#edit-category').modal('show');
                    }
                },
                error: function(error) {
                    alert('Có lỗi xảy ra, vui lòng thử lại sau');
                }
            });
        }
    </script>


@endsection
