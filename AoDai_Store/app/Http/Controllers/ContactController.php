<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
class ContactController extends Controller
{
    public function index()
    {
        return view('client.contact.index');
    }
    public function store(Request $request)
    {
         $request->validate([
            'ho_ten'   => 'required',
            'email'    => 'required|email',
            'noi_dung' => 'required',
        ]);

        Contact::create([
            'MaTaiKhoan'    => Auth::check() ? Auth::id() : null,
            'HoTen'   => Auth::check() ? Auth::user()->HoTen : $request->ho_ten,
            'Email'   => Auth::check() ? Auth::user()->Email : $request->email,
            'NoiDung' => $request->noi_dung,
        ]);


         return redirect()
            ->route('contact.index')
            ->with('success', 'Gửi liên hệ thành công!');
    }
    
}
