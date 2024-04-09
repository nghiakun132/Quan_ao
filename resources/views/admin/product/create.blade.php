@extends('admin.layouts.index')
@section('title', 'Quản lý sản phẩm')
@section('content')
    <h3>
        Thêm sản phẩm
    </h3>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data"
                id="form-create-product">
                @csrf
                <div
                    class="form-group
                    @error('name')
                        text-danger
                    @enderror">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div
                    class="form-group
                    @error('category_id')
                        text-danger
                    @enderror">
                    <label for="category_id">Danh mục</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div
                    class="form-group
                    @error('brand_id')
                        text-danger
                    @enderror">
                    <label for="brand_id">Nhà sản xuất</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="">Chọn nhà sản xuất</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="row" id="form-size-quantity">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50%">Size</th>
                                <th style="width: 50%">Số lượng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @error('size.*')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <select name="size[]" id="size" class="form-control">
                                        <option value="">Chọn size</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @error('quantity.*')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <input type="number" class="form-control" name="quantity[]" id="quantity"
                                        value="0">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-size-quantity">-</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center col-12">
                    <button type="button" class="btn btn-primary" id="add-size-quantity">+</button>
                </div>
                <div
                    class="form-group
                    @error('image')
                        text-danger
                    @enderror">
                    <label for="image">Avatar</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" />
                    @error('image')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div
                class="form-group
                @error('image')
                    text-danger
                @enderror">
                <label for="image">Ảnh</label>
                <input type="file" class="form-control" name="images[]" id="images" accept="image/*" multiple/>
            </div>
                <div
                    class="form-group
                    @error('price')
                        text-danger
                    @enderror">
                    <label for="price">Giá</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}">
                    @error('price')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div
                class="form-group
                @error('sale')
                    text-danger
                @enderror">
                <label for="sale">Giảm giá</label>
                <input type="number" class="form-control" name="sale" id="sale" value="{{ old('sale') }}">
                @error('sale')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>
                <div
                    class="form-group
                    @error('description')
                        text-danger
                    @enderror">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <button id="btn-submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            $('#add-size-quantity').click(function() {


                $("#form-size-quantity table tbody").append(`
                    <tr>
                        <td>
                            <select name="size[]" id="size" class="form-control">
                                <option value="">Chọn size</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity[]" id="quantity" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-size-quantity">-</button>
                        </td>
                    </tr>
                `);

            });

            $(document).on('click', '.remove-size-quantity', function() {
                $(this).closest('tr').remove();
            });
        });

        $("#btn-submit").click(function(e) {
            e.preventDefault();

            validateSizeAndQuantity()
        })

        function validateSizeAndQuantity() {
            let size = $("select[name='size[]']").map(function() {
                return $(this).val();
            }).get();

            let quantity = $("input[name='quantity[]']").map(function() {
                return $(this).val();
            }).get();

            let isValid = true;

            for (let i = 0; i < size.length; i++) {
                if (size[i] == "") {
                    isValid = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng chọn size'
                    })
                    break;
                }
            }

            if (isValid) {
                $("#form-create-product").submit();
            }
        }
    </script>
@endsection
