<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function index(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->with(['childrenRecursive'])->first();

        if (!$category) {
            abort(404);
        }

        $listCategories = $category->descendant_names;

        $products = Product::whereIn('category_id', $listCategories)
            ->with(['category', 'size', 'brand']);

        $sort = $request->input('sort', '');

        if (!empty($sort)) {
            $sort = explode('_', $sort);
            $sortBy = Arr::get($sort, 0);
            $sortType = Arr::get($sort, 1);

            $products = $products->orderBy($sortBy, $sortType);
        }

        if (!empty($request->input('size'))) {
            $size = Size::where('slug', $request->input('size'))->first();
            $sizes = ProductSize::where(
                'size_id',
                $size->id
            )->pluck('product_id');

            $products = $products->whereIn('id', $sizes);
        }

        if(!empty($request->input('brand'))) {
            $products = $products->whereIn('brand_id',explode(',', $request->input('brand')));
        }

        if(!empty($request->input('gia_tu'))){
            $products = $products->where('price', '>=', $request->input('gia_tu'));
        }

        if(!empty($request->input('gia_den'))){
            $products = $products->where('price', '<=', $request->input('gia_den'));
        }

        $brands = $products->pluck('brand_id')->unique()->toArray();
        $brands = Brand::whereIn('id', $brands)->get();

        $productId = $products->pluck('id')->toArray();
        $sizeId = ProductSize::whereIn('product_id', $productId)->pluck('size_id')->toArray();
        $sizes = Size::whereIn('id', $sizeId)->get();
        $products = $products->paginate($request->input('per_page', 15));
        $data = [
            'category' => $category,
            'products' => $products,
            'brands' => $brands,
            'sizes' => $sizes,
        ];

        return view('user.category.index', $data);
    }


}
