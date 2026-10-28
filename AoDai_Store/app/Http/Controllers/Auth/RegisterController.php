<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|unique:taikhoan,TenDangNhap|regex:/^[a-zA-Z0-9_]+$/|max:50',
            'MatKhau'     => 'required|min:6|confirmed|max:32',
            'HoTen'       => 'required|regex:/^[\pL\s]+$/u',
            'Email'       => 'required|email|unique:taikhoan,Email',
            'SoDienThoai' => 'nullable|regex:/^[0-9]{10,11}$/',
            'DiaChi'      => 'nullable|string|max:255',
        ], [
            'TenDangNhap.unique' => 'Tên đăng nhập đã tồn tại.',
            'TenDangNhap.regex'    => 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới.',
            'TenDangNhap.max'      => 'Tên đăng nhập không được vượt quá :max ký tự.',
            'HoTen.regex'          => 'Họ tên chỉ được chứa chữ cái.',
            'MatKhau.confirmed'  => 'Mật khẩu xác nhận không khớp.',
            'MatKhau.min'         => 'Mật khẩu phải ít nhất :min ký tự.',
            'MatKhau.max'         => 'Mật khẩu không được vượt quá :max ký tự.',
            'Email.unique'       => 'Email này đã được sử dụng.',
            'SoDienThoai.regex' => 'Số điện thoại chỉ được chứa chữ số và phải có độ dài 10-11 ký tự.',
            'DiaChi.max'        => 'Địa chỉ không được vượt quá 255 ký tự.'
        ]);

        Account::create([
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau'     => Hash::make($request->MatKhau), 
            'HoTen'       => $request->HoTen,
            'Email'       => $request->Email,
            'SDT'         => $request->SoDienThoai,
            'DiaChi'      => $request->DiaChi,
            'Role'        => 'User', 
            'TrangThai'   => 1,
            'CreatedDate' => now(),
        ]);

        return redirect('/')->with('openLoginModal', true)
                     ->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');

    }
}
