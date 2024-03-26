<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::get();

        return view('admin.discount.index', compact('discounts'));
    }

    public function store(Request $request)
    {
        try {

            $validated = Validator::make($request->all(), [
                'percent' => 'required',
                'start_at' => 'required',
                'end_at' => 'required',
                'quantity' => 'required',
            ], [
                'percent.required' => 'Vui lòng nhập phần trăm giảm giá',
                'start_at.required' => 'Vui lòng nhập ngày bắt đầu',
                'end_at.required' => 'Vui lòng nhập ngày kết thúc',
                'quantity.required' => 'Vui lòng nhập số lượng mã giảm giá'

            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validated->errors()
                ], 400);
            }

            $data = [
                'code' => "MGG-" . rand(1000, 9999) . "-" . $this->randomCode(),
                'percent' => $request->percent,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'quantity' => $request->quantity,
                'description' => $request->description
            ];


            Discount::create($data);

            return response()->json([
                'status' => 200,
                'message' => 'Thêm mới mã giảm giá thành công'
            ], 200);

        } catch (Exception $ex) {
            report($ex);

            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $discount = Discount::find($request->id);

            if (!$discount) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy mã giảm giá'
                ], 404);
            }

            $validated = Validator::make($request->all(), [
                'percent' => 'required',
                'start_at' => 'required',
                'end_at' => 'required',
                'quantity' => 'required',
            ], [
                'percent.required' => 'Vui lòng nhập phần trăm giảm giá',
                'start_at.required' => 'Vui lòng nhập ngày bắt đầu',
                'end_at.required' => 'Vui lòng nhập ngày kết thúc',
                'quantity.required' => 'Vui lòng nhập số lượng mã giảm giá'

            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validated->errors()
                ], 400);
            }

            $data = [
                'percent' => $request->percent,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'quantity' => $request->quantity,
                'description' => $request->description
            ];

            $discount->update($data);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật mã giảm giá thành công'
            ], 200);

        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }

    protected function randomCode()
    {
        $listChar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $listChar[rand(0, strlen($listChar) - 1)];
        }

        return $code;
    }

    public function edit($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy mã giảm giá'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $discount
        ], 200);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $discount = Discount::find($id);

            if (!$discount) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy mã giảm giá'
                ], 404);
            }

            $discount->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Xóa mã giảm giá thành công'
            ], 200);

        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }
}
