<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('NgayTao', 'asc')->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    //form cap nhat
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }
    //xu ly cap nhat
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'HoTen' => 'required',
            'Email' => 'required|email',
            'NoiDung' => 'required'
        ]);

        $contact->update($request->only('HoTen', 'Email', 'NoiDung'));

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Cập nhật liên hệ thành công!');
    }
    //xoa
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Xóa liên hệ thành công!');
    }
}


