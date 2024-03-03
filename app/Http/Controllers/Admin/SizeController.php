<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();

        return view('admin.size.index', compact('sizes'));
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:sizes',
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.unique' => 'Tên size đã tồn tại',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
                'status' => 400,
            ], 400);
        }

        Size::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'message' => 'Thêm mới thành công',
            'status' => 200,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $size = Size::find($id);

        return response()->json([
            'data' => $size,
            'status' => 200,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:sizes,name,' . $id,
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.unique' => 'Tên size đã tồn tại',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
                'status' => 400,
            ], 400);
        }

        $size = Size::find($id);
        $size->name = $request->name;
        $size->slug = Str::slug($request->name);
        $size->save();

        return response()->json([
            'message' => 'Cập nhật thành công',
            'status' => 200,
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $size = Size::find($id);
        $size->delete();

        return  redirect()->back()->with('success', 'Xóa thành công');
    }
}
