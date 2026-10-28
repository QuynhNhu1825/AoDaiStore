<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
   public function index(Request $request)
{
    $query = Post::query();

    if ($request->filled('search')) {
        $query->where('TieuDe', 'like', '%'.$request->search.'%');
    }

    $baiViets = $query->orderByDesc('NgayTao')->get();

    return view('admin.post.index', compact('baiViets'));
}

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TieuDe' => 'required|max:255',
            'NoiDung' => 'required',
            'LoaiBaiViet' => 'required'
        ]);

        Post::create([
            'TieuDe' => $request->TieuDe,
            'Slug' => Str::slug($request->TieuDe),
            'NoiDung' => $request->NoiDung,
            'LoaiBaiViet' => $request->LoaiBaiViet,
            'TrangThai' => 1,
            'NgayTao' => now(),
            'NgayCapNhat' => now()
        ]);

        return redirect()->route('admin.baiviet.index')
            ->with('success', 'Thêm bài viết thành công');
    }

    public function edit($id)
    {
        $baiViet = Post::findOrFail($id);
        return view('admin.post.edit', compact('baiViet'));
    }

    public function update(Request $request, $id)
    {
        $baiViet = Post::findOrFail($id);

        $baiViet->update([
            'TieuDe' => $request->TieuDe,
            'Slug' => Str::slug($request->TieuDe),
            'NoiDung' => $request->NoiDung,
            'LoaiBaiViet' => $request->LoaiBaiViet,
            'TrangThai' => $request->TrangThai,
            'NgayCapNhat' => now()
        ]);

        return redirect()->route('admin.baiviet.index')
            ->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return back()->with('success', 'Đã xóa bài viết');
    }
}
