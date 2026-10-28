<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return redirect('/?login=1');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string|max:50|regex:/^[a-zA-Z0-9_]+$/',
            'MatKhau'     => 'required|string|min:6|max:32',
        ], [
            'TenDangNhap.required' => 'Vui lòng nhập tên đăng nhập.',
            'TenDangNhap.regex'    => 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới.',
            'TenDangNhap.max'      => 'Tên đăng nhập không được vượt quá :max ký tự.',

            'MatKhau.required'    => 'Vui lòng nhập mật khẩu.',
            'MatKhau.min'         => 'Mật khẩu phải ít nhất :min ký tự.',
            'MatKhau.max'         => 'Mật khẩu không được vượt quá :max ký tự.',
        ]);

        // Check user tồn tại
        $user = Account::where('TenDangNhap', $request->TenDangNhap)->first();

        if (!$user) {
            return back()->withErrors([
                'TenDangNhap' => 'Tên đăng nhập không tồn tại.',
            ]);
        }

        // Check trạng thái tài khoản
        if ($user->TrangThai != 1) {
            return back()->withErrors([
                'TenDangNhap' => 'Tài khoản đã bị khóa hoặc ngưng hoạt động.',
            ]);
        }

        // Check mật khẩu
        if (!Hash::check($request->MatKhau, $user->MatKhau)) {
            return back()->withErrors([
                'MatKhau' => 'Mật khẩu không chính xác.',
            ]);
        }

        $credentials = [
            'TenDangNhap' => $request->TenDangNhap,
            'password' => $request->MatKhau, // Laravel sẽ tự check hash
        ];
         
          $cartController = new CartController();
         
            $oldSessionId = session()->getId();
        if (Auth::attempt($credentials)) {
             
             
            $request->session()->regenerate();
             $cartController->mergeCartAfterLogin($oldSessionId);
             $user = Auth::user();
            if($user->Role == 'Admin'){
                return redirect()->route('admin.dashboard');
            } elseif ($user->Role == 'User') {
                return redirect('/');
            }
        }

        return back()->withErrors([
            'TenDangNhap' => 'Tên đăng nhập hoặc mật khẩu sai',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
