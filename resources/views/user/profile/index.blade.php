@extends('user.layouts.index')
@section('title', 'Thông tin tài khoản của tôi')
@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>
                            Tài khoản của tôi
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
                    <form action="{{ route('user.profile.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Tên</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ $user->phone }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="birthday">Ngày sinh</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday"
                                                value="{{ $user->birthday }}">
                                            @error('birthday')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            <button type="button" class="btn btn-primary ml-2" id="btn-change-password">
                                                Đổi mật khẩu</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="change-password-form" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Đổi mật khẩu
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user.change_password') }}" method="post">
                            <div class="form-group">
                                <label for="password">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    oninput="$(this).removeClass('is-invalid');$('#error-password').text('')">
                                <p class="text-danger" id="error-password"></p>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    oninput="$(this).removeClass('is-invalid');$('#error-new_password').text('')">
                                <p class="text-danger" id="error-new_password"></p>

                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Nhập lại mật khẩu mới</label>
                                <input class="form-control" id="confirm_password" name="confirm_password" type="password"
                                    oninput="$(this).removeClass('is-invalid');$('#error-confirm_password').text('')">
                                <p class="text-danger" id="error-confirm_password"></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Đóng
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-save-change-password">
                            Đổi mật khẩu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            $('#btn-change-password').click(function() {
                $('#change-password-form').modal('show');
            });
        });

        $('#btn-save-change-password').click(function() {
            let password = $('#password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();
            let error = false;


            $.ajax({
                url: "{{ route('user.change_password') }}",
                type: 'POST',
                data: {
                    password: password,
                    new_password: new_password,
                    confirm_password: confirm_password
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#change-password-form').modal('hide');
                        Swal.fire(
                            'Thành công',
                            response.message,
                            'success'
                        )
                    }
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;

                    Object.keys(errors).forEach(function(key) {
                        $("#" + key).addClass('is-invalid');
                        $("#error-" + key).text(errors[key].join(' '));
                    });
                }
            });
        });
    </script>

@endsection
