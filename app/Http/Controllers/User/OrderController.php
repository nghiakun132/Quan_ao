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
            ->with(['details.product', 'details.size', 'cancel'])
            ->first();

        return view('user.order.detail', compact('order'));
    }

    public function cancel(Request $request)
    {
        DB::beginTransaction();
        try {

            $code = $request->code;

            if (!$code) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã đơn hàng không tồn tại'
                ]);
            }

            $order = Order::where('code', $code)->first();
            $order->status = Order::CANCEL;
            $order->save();

            $order->cancel()->create([
                'reason' => $request->reason
            ]);

            foreach ($order->details as $detail) {
                ProductSize::where('product_id', $detail->product_id)
                    ->where('size_id', $detail->size_id)
                    ->increment('quantity', $detail->quantity);
            }

            $order->userDiscount()->delete();
            $order->discount()->increment('quantity');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Hủy đơn hàng thành công'
            ]);

        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Hủy đơn hàng thất bại'
            ]);
        }
    }
}
