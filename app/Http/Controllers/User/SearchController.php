<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $brands = Brand::limit(10)->get();
        $sizes = Size::limit(10)->get();

        $products = Product::query()->with('brand', 'size')
            ->where('name', 'like', '%' . $request->keyword . '%');



        $data = [
            'brands' => $brands,
            'sizes' => $sizes,
            'products' => $products->paginate($request->input('per_page', 20)),
        ];
        return view('user.search.index', $data);
    }
}
