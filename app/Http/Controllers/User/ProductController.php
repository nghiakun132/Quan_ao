<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::where('slug', $slug)->with(
            ['images', 'category', 'brand', 'size']
        )->first();

        if (!$product) {
            return abort(404);
        }

        return view('user.product.index', compact('product'));
    }
}
