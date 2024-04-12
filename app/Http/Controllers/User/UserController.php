<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Province;
use App\Models\Size;
use App\Models\User;
use App\Models\Ward;
use App\Models\WhiteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            if (Auth::user()->status == 1) {
                Auth::logout();
                return redirect()->route('user.login')->with(
                    'error',
                    'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ admin để được hỗ trợ'
                )->withInput();
            }

            if ($request->remember == 'on') {
                Cookie::queue('email', $request->email, 60 * 24 * 30);
                Cookie::queue('password', $request->password, 60 * 24 * 30);
                Cookie::queue('remember', 'on', 60 * 24 * 30);
            }

            if (!empty($request->redirect)) {
                return redirect($request->redirect);
            }

            return redirect()->route('home');
        } else {
            return redirect()->route('user.login')->with('error', 'Email hoặc mật khẩu không đúng')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home')->withCookie(Cookie::forget('email'))
            ->withCookie(Cookie::forget('password'))
            ->withCookie(Cookie::forget('remember'));
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
        $user = Auth::user();

        return view('user.profile.index', compact('user'));
    }


    public function addWhiteList($id)
    {
        WhiteList::updateOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id
        ], [
            'user_id' => Auth::id(),
            'product_id' => $id
        ]);

        return redirect()->back()->with('success', 'Thêm vào danh sách yêu thích thành công');
    }

    public function getWhiteList(Request $request)
    {
        $brands = Brand::limit(10)->get();
        $sizes = Size::limit(10)->get();

        $whiteLists = WhiteList::where('user_id', Auth::id())
            ->with(['product'])->paginate($request->input('per_page', 10));

        $data = [
            'brands' => $brands,
            'sizes' => $sizes,
            'whiteLists' => $whiteLists
        ];

        return view('user.white_list', $data);
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'phone' => 'required',
            'email' => 'required|email',
            'birthday' => 'required|date'
        ], [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không quá 50 ký tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'birthday.required' => 'Ngày sinh không được để trống',
            'birthday.date' => 'Ngày sinh không đúng định dạng'
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin thành công');
    }

    public function changePassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:new_password'
        ], [
            'password.required' => 'Mật khẩu cũ không được để trống',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.min' => 'Mật khẩu mới ít nhất 6 ký tự',
            'new_password.max' => 'Mật khẩu mới không quá 20 ký tự',
            'confirm_password.required' => 'Mật khẩu xác nhận không được để trống',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp'
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors(), 'status' => 'error'], 400);
        }

        $user = User::find(Auth::id());

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['message' => 'Cập nhật mật khẩu thành công', 'status' => 'success'], 200);
        }

        return response()->json([
            'errors' => [
                'password' => ['Mật khẩu cũ không đúng']
            ],
            'status' => 'error'
        ], 400);
    }

    public function getAddress()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
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


        return view('user.address.index', compact('addresses', 'provinces'));
    }

    public function addAddress(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ], [
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'province.required' => 'Tỉnh/Thành phố không được để trống',
            'district.required' => 'Quận/Huyện không được để trống',
            'ward.required' => 'Phường/Xã không được để trống',
        ]);

        $address = new Address([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'user_id' => Auth::id()
        ]);

        $address->save();

    }
}
