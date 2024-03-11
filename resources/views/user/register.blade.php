@extends('user.layouts.index')
@section('title', 'Đăng ký')
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
                            Đăng ký
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
                    <div class="register-form">
                        <h2>
                            Đăng ký
                        </h2>
                        <form action="{{ route('user.register.post') }}" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="name">
                                    Name <span class="text-danger"> *</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    @error('name') style="border:1px solid red"
                                        oninput="$(this).css('border', '1px solid #ebebeb');
                                        $(this).next().text('')"
                                    @enderror>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="email">
                                    Email <span class="text-danger"> *</span>
                                </label>
                                <input type="text" id="email" name="email" value="{{ old('email') }}"
                                    @error('email') style="border:1px solid red"
                                oninput="$(this).css('border', '1px solid #ebebeb');  $(this).next().text('')"
                            @enderror>

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="group-input">
                                <label for="pass">Mật khẩu <span class="text-danger"> *</span></label>
                                <input type="password" id="pass" name="password" value="{{ old('password') }}"
                                    @error('password') style="border:1px solid red"
                                oninput="$(this).css('border', '1px solid #ebebeb');  $(this).next().text('')"
                            @enderror>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="group-input">
                                <label for="con-pass">Xác nhận mật khẩu <span class="text-danger"> *</span></label>
                                <input type="password" id="con-pass" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                    @error('password_confirmation') style="border:1px solid red"
                                oninput="$(this).css('border', '1px solid #ebebeb');  $(this).next().text('')"
                            @enderror>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="site-btn register-btn">Đăng ký</button>
                        </form>
                        <div class="switch-login">
                            <a href="{{ route('user.login') }}" class="or-login">Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
