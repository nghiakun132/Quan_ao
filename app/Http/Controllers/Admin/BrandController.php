<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy("name", "asc")->get();

        return view('admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Tên nhà sản xuất không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'email.required' => 'Email không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
        }
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        Brand::insert($data);
        return response()->json(['message' => 'Thêm nhà sản xuất thành công', 'status' => 200], 200);

    }

    public function edit(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brand.edit', compact('brand'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Tên nhà sản xuất không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'email.required' => 'Email không được để trống',
        ]);

        $brand = Brand::findOrFail($id);

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.brand.index')->with('success', 'Cập nhật nhà sản xuất thành công');
    }

    public function destroy(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->back()->with('success', 'Xóa nhà sản xuất thành công');
    }
}
