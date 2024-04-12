@extends('admin.layouts.index')
@section('title', 'Sửa sản phẩm')
@section('content')
    <h3>
        Sửa sản phẩm
    </h3>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div
                    class="form-group
                    @error('name')
                        text-danger
                    @enderror">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
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
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
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
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div
                    class="form-group
                    @error('price')
                        text-danger
                    @enderror">
                    <label for="price">Giá</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{ $product->price }}">
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
                    <label for="sale">Giá</label>
                    <input type="number" class="form-control" name="sale" id="sale" value="{{ $product->sale }}">
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
                    <textarea name="description" id="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                    @error('description')
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
                    <label for="image">Avatar</label>
                    <img src="{{ $product->image }}" alt="" style="width: 100px; height: 100px">
                    <input type="file" class="form-control" name="image" id="image">
                    @error('image')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="images">Hình ảnh</label>
                    <input type="file" class="form-control" name="images[]" id="images" multiple
                        onchange="previewImages()">
                    <div class="preview-image">
                        @foreach ($product->images as $image)
                            <img src="{{ $image->path }}" alt="" style="width: 100px; height: 100px">
                        @endforeach
                    </div>
                </div>
                <div>
                    <h4>
                        Size và số lượng
                    </h4>
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
                                @foreach ($product->size as $productSize)
                                    <tr>
                                        <td>
                                            <select name="size[]" id="size" class="form-control">
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ $size->id == $productSize->pivot->size_id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="quantity[]" id="quantity"
                                                value="{{ $productSize->pivot->quantity }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-size-quantity">-</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center col-12">
                        <button type="button" class="btn btn-primary" id="add-size-quantity">+</button>
                    </div>
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

        function previewImages() {
            var preview = document.querySelector('.preview-image');
            var fileInput = document.querySelector("#images");

            if (fileInput.files.length === 0) {
                return;
            }

            preview.innerHTML = "";

            Object.values(fileInput.files).forEach(function(item) {
                var reader = new FileReader();

                reader.onload = function(e) {

                    var img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.width = "100px";
                    img.style.height = "100px";
                    img.style.margin = "4px";
                    preview.appendChild(img);
                };

                reader.readAsDataURL(item);
            });

        }
    </script>
@endsection
