<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();

        return view('user.order.index', compact('orders'));
    }

    public function show($code)
    {
        $order = Order::where('code', $code)
            ->with(['details.product', 'details.size'])
            ->first();

        return view('user.order.detail', compact('order'));
    }

    public function cancel($code)
    {
        DB::beginTransaction();
        try {

            $order = Order::where('code', $code)->first();
            $order->status = Order::CANCEL;
            $order->save();

            foreach ($order->details as $detail) {
                ProductSize::where('product_id', $detail->product_id)
                    ->where('size_id', $detail->size_id)
                    ->increment('quantity', $detail->quantity);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Hủy đơn hàng thành công');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hủy đơn hàng thất bại');
        }
    }
}
