@extends('user.layouts.index')
@section('title', 'Chi tiết đơn hàng')
@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>
                            Chi tiết đơn hàng
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
