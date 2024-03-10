<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)
            ->with(['product', 'size'])
            ->get();

        return view('user.cart.index', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();

        if (!auth()->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng',
            ], 400);
        }

        $cart = Cart::where(
            'user_id',
            auth()->user()->id
        )->where(
                'product_id',
                $request->productId
            )->where('size_id', $request->size)
            ->first();

        if (empty($cart)) {
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $request->productId;
            $cart->quantity = $request->quantity;
            $cart->size_id = $request->size;

        } else {
            $cart->quantity += $request->quantity;
        }

        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
        ], 200);
    }

    public function clean()
    {
        Cart::where('user_id', auth()->user()->id)->delete();

        return redirect()->back()->with('success', 'Xóa giỏ hàng thành công');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công');
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $carts = $request->input('cart');

            foreach ($carts as $value) {
                Cart::where('id', $value['id'])->update(['quantity' => $value['quantity']]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật giỏ hàng thành công',
            ], 200);

        } catch (Exception $ex) {
            DB::rollBack();
            report($ex);

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
            ], 500);
        }
    }

    public function checkout()
    {
        $carts = Cart::where('user_id', auth()->user()->id)
            ->with(['product', 'size'])
            ->get();

        return view('user.cart.checkout', compact('carts'));
    }
}
