<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        ->with(['category', 'size'])
        ->get();

        dd($products->toArray());


    }


}
