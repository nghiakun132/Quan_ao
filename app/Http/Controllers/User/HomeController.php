<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index()
    {
        $categoryParents = Category::whereIn('id', [1, 2, 3])->get();


        $menCategory = Category::where('parent_id', 1)->pluck('id');
        $womenCategory = Category::where('parent_id', 2)->pluck('id');
        $kidsCategory = Category::where('parent_id', 3)->pluck('id');

        $womenProducts = Product::whereIn('category_id', $womenCategory)
            ->inRandomOrder('id')
            ->orderBy('id', 'desc')->limit(8)->get();

        $menProducts = Product::whereIn('category_id', $menCategory)
            ->inRandomOrder('id')->limit(8)->get();
        $kidsProducts = Product::whereIn('category_id', $kidsCategory)
            ->inRandomOrder('id')->limit(8)->get();

        $data = [
            'categoryParents' => $categoryParents,
            'womenProducts' => $womenProducts,
            'menProducts' => $menProducts,
            'kidsProducts' => $kidsProducts,
        ];

        return view('user.index', $data);
    }
}
