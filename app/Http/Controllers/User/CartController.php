<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDetail;
use App\Models\ProductSize;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng',
            // ], 400);


            //use Cookie

            $cart = json_decode($request->cookie('cart'), true);

            if (empty($cart)) {
                $cart = [];
            }

            $key = $request->productId . '-' . $request->size;

            if (array_key_exists($key, $cart)) {
                $cart[$key] += $request->quantity;
            } else {
                $cart[$key] = $request->quantity;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            ])->cookie('cart', json_encode($cart), 60 * 24 * 30);
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

        $address = User::where('id', Auth::id())->first()->getDefaultAddress();

        if (Cache::has('provinces')) {
            $provinces = Cache::get('provinces');
        } else {
            $provinces = Province::pluck('name', 'id')->toArray();

            $provinces = collect($provinces)->map(function ($value, $key) {
                return [
                    'id' => $key,
                    'name' => $value,
                ];
            })->toArray();

            Cache::forever('provinces', $provinces);
        }

        if (!empty($address)) {


            if (Cache::has('districts')) {
                $districts = Cache::get('districts_' . $address->province);
            } else {
                $districts = District::where('province_id', $address->province)->pluck('name', 'id')->toArray();

                $districts = collect($districts)->map(function ($value, $key) {
                    return [
                        'id' => $key,
                        'name' => $value,
                    ];
                })->toArray();

                Cache::forever('districts_' . $address->province, $districts);
            }

            if (Cache::has('wards_' . $address->district)) {
                $wards = Cache::get('wards_' . $address->district);
            } else {
                $wards = Ward::where('district_id', $address->district)->pluck('name', 'id')->toArray();

                $wards = collect($wards)->map(function ($value, $key) {
                    return [
                        'id' => $key,
                        'name' => $value,
                    ];
                })->toArray();

                Cache::forever('wards_' . $address->district, $wards);
            }
        }
        $data = [
            'carts' => $carts,
            'address' => $address,
            'provinces' => $provinces ?? [],
            'districts' => $districts ?? [],
            'wards' => $wards ?? [],
        ];

        return view('user.cart.checkout', $data);
    }

    public function checkoutPost(Request $request)
    {

        DB::beginTransaction();
        try {

            $carts = Cart::where('user_id', auth()->user()->id)
                ->with(['product', 'size'])
                ->get();

            $orderDetail = [];

            $total = 0;

            foreach ($carts as $cart) {
                $total += $cart->quantity * $cart->product->price;
                $orderDetail[] = [
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'size_id' => $cart->size_id,
                ];

                $productSize = ProductSize::where('product_id', $cart->product_id)
                    ->where('size_id', $cart->size_id)
                    ->first();

                if ($productSize->quantity < $cart->quantity) {
                    return redirect()->back()->with('error', 'Sản phẩm ' . $cart->product->name . ' - ' . $cart->size->name . ' không đủ số lượng');
                }

                $productSize->quantity -= $cart->quantity;
                $productSize->save();
            }

            $order = new Order();
            $order->code = 'DH' . '-' . auth()->id() . Carbon::now()->format('YmdHis');
            $order->user_id = auth()->id();
            $order->shipping_fee = 0;
            $order->total = $total;
            $order->status = 0;
            $order->discount = 0;
            $order->note = $request->note;
            $order->save();

            $orderDetail = Arr::map($orderDetail, function ($item) use ($order) {
                $item['order_id'] = $order->id;
                return $item;
            });

            OrderDetail::insert($orderDetail);

            OrderAddress::create([
                'order_id' => $order->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'province' => $request->province,
                'district' => $request->district,
                'ward' => $request->ward,
            ]);

            if ($request->input('save_address') == 'on') {
                Address::where('user_id', auth()->id())->update(['is_default' => 0]);

                Address::create([
                    'user_id' => auth()->id(),
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'province' => $request->province,
                    'district' => $request->district,
                    'ward' => $request->ward,
                    'is_default' => 1,
                ]);
            }

            Cart::where('user_id', auth()->user()->id)->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Đặt hàng thành công');
        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
}
