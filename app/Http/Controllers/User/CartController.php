<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('user.cart.index');
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();
        dd($data);
    }
}
