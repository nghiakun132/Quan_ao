<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        $email = Cookie::get('email');
        $password = Cookie::get('password');
        $remember = Cookie::get('remember');

        return view('user.login', compact('email', 'password', 'remember'));
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không quá 20 ký tự'
        ]);

        $user = $request->only('email', 'password');

        if (Auth::attempt($user)) {
            if ($request->remember == 'on') {
                Cookie::queue('email', $request->email, 60 * 24 * 30);
                Cookie::queue('password', $request->password, 60 * 24 * 30);
                Cookie::queue('remember', 'on', 60 * 24 * 30);
            }

            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home')->withCookie(Cookie::forget('email'))
            ->withCookie(Cookie::forget('password'))
            ->withCookie(Cookie::forget('remember'))->with('success', 'Đăng xuất thành công');
    }

    public function register(Request $request)
    {
        return view('user.register');
    }

    public function registerPost(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|max:50',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không quá 20 ký tự',
            'password_confirmation.required' => 'Mật khẩu xác nhận không được để trống',
            'password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên ít nhất 6 ký tự',
            'name.max' => 'Tên không quá 50 ký tự'
        ]);


        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công');
    }

    public function profile(Request $request)
    {
        return view('user.profile');
    }

    public function getWhiteList(Request $request)
    {
        return view('user.white_list');
    }
}
