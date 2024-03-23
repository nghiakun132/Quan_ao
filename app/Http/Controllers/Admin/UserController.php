<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['addresses'])->get();

        $data = [
            'users' => $users,
        ];

        return view(
            'admin.user.index',
            $data
        );
    }

    public function changeStatus($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = !$user->status;
            $user->save();
        }

        return redirect()->route('admin.user.index')->with('success', 'Cập nhật trạng thái thành công');
    }
}
