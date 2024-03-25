@extends('user.layouts.index')
@section('title', 'Đăng nhập')
@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i>
                            Trang chủ
                        </a>
                        <span>
                            Đăng nhập
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Đăng nhập</h2>
                        <form action="{{ route('user.login.post', ['redirect' => request()->input('redirect')]) }}"
                            method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="username">Email*</label>
                                <input type="text" name="email" value="{{ !empty($email) ? $email : old('email') }}"
                                    id="username" required>

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="group-input">
                                <label for="pass">Mật khẩu*</label>
                                <input type="password" id="pass" name="password"
                                    value="{{ !empty($password) ? $password : old('password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass">
                                        Lưu mật khẩu
                                        <input type="checkbox" id="save-pass" name="remember"
                                            {{ old('remember') || !empty($remember) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="site-btn login-btn">Đăng nhập</button>
                        </form>
                        <div class="switch-login">
                            <a href="{{ route('user.register') }}" class="or-login">
                                Tạo tài khoản mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
