@extends('admin.layouts.index')
@section('title', 'Sửa nhà sản xuất')
@section('content')
    <h3>
        Sửa nhà sản xuất
    </h3>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.brand.update', $brand->id) }}" method="post">
                @csrf
                <div class="form-group
                    @error('name')
                        text-danger
                    @enderror">
                    <label for="name">Tên nhà sản xuất</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $brand->name }}">
                    @error('name')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-group
                    @error('email')
                        text-danger
                    @enderror">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $brand->email }}">
                    @error('email')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-group
                    @error('phone')
                        text-danger
                    @enderror">
                    <label for="phone">Số điện thoại</label>
                    <input type="number" class="form-control" name="phone" id="phone" value="{{ $brand->phone }}">
                    @error('phone')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-group
                    @error('address')
                        text-danger
                    @enderror">
                    <label for="address">Địa chỉ</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ $brand->address }}">
                    @error('address')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
