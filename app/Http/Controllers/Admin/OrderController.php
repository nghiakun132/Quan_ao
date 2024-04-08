<?php

namespace App\Http\Controllers\Admin;

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
        $orders = Order::with(['details', 'user', 'orderAddress'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['details', 'user', 'orderAddress', 'cancel'])->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();


            if ($request->status == Order::CANCEL) {
                foreach ($order->details as $detail) {
                    ProductSize::where('product_id', $detail->product_id)
                        ->where('size_id', $detail->size_id)
                        ->increment('quantity', $detail->quantity);
                }

                $orderCancels = [
                    'reason' => 'Đơn hàng đã bị hủy bởi Admin. Vui lòng liên hệ để biết thêm chi tiết.',
                    'order_id' => $order->id
                ];

                $order->cancel()->create($orderCancels);

                $order->userDiscount()->delete();
                $order->discount()->increment('quantity');
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái đơn hàng thành công!'
            ]);
        } catch (Exception $e) {
            report($e);

            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau!'
            ]);
        }
    }
}
