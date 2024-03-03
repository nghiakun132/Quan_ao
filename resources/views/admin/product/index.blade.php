@extends('admin.layouts.index')
@section('title', 'Quản lý sản phẩm')
@section('content')
    <h3>
        Quản lý sản phẩm
    </h3>

    <div class="row">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{route('admin.product.create')}}" class="btn btn-primary" target="_blank">Thêm mới</a>
            </div>
        </div>

        <div class="col-12 mt-2">
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>
                            Danh mục
                        </th>
                        <th>
                            Nhà sản xuất
                        </th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>
                            Mô tả
                        </th>

                        <th style="width: 13%">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width: 100px; height: 100px">
                            </td>
                            <td>{{ number_format($product->price) }} VNĐ</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                    class="btn btn-primary">Sửa</a>
                                <a href="{{ route('admin.product.delete', $product->id) }}" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
