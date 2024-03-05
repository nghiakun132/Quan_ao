<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['children', 'parent'])
            ->orderBy('id', 'DESC')->get();

        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name',

        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 400);
        }

        Category::insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'parent_id' => is_null($request->parent_id) ? 0 : $request->parent_id,
        ]);

        return response()->json(['message' => 'Thêm danh mục thành công', 'status' => 200], 200);
    }

    public function edit(string $id)
    {
        $data = Category::where('id', $id)
            ->with(['parent'])
            ->first();

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name,' . $id . ',id'
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'name.unique' => 'Tên danh mục đã tồn tại',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 400);
        }

        Category::where('id', $id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'parent_id' => is_null($request->parent_id) ? 0 : $request->parent_id,
        ]);

        return response()->json(['message' => 'Cập nhật danh mục thành công', 'status' => 200], 200);
    }

    public function destroy(string $id)
    {
        Category::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
}
