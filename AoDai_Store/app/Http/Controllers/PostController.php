<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Trang giới thiệu
    public function gioiThieu()
{
    // 1. Bài viết giới thiệu (chỉ 1)
    $gioiThieu = Post::where('LoaiBaiViet', 'gioi_thieu')
        ->where('TrangThai', 1)
        ->first();

    // 2. Blog (lấy 3 bài mới nhất)
    $blogs = Post::where('LoaiBaiViet', 'blog')
        ->where('TrangThai', 1)
        ->orderByDesc('NgayTao')
        ->limit(3)
        ->get();

    // 3. Bài viết sản phẩm (lấy 3 bài mới nhất)
    $baiVietSanPham = Post::where('LoaiBaiViet', 'san_pham')
        ->where('TrangThai', 1)
        ->orderByDesc('NgayTao')
        ->limit(3)
        ->get();

    return view(
        'client.post.about',
        compact('gioiThieu', 'blogs', 'baiVietSanPham')
    );
}


    // Danh sách blog + tìm kiếm + phân trang
    public function index(Request $request)
    {
        $query = Post::whereIn('LoaiBaiViet', ['blog', 'san_pham'])
            ->where('TrangThai', 1);

        if ($request->filled('keyword')) {
            $query->where('TieuDe', 'like', '%'.$request->keyword.'%');
        }

        $baiViets = $query->orderByDesc('NgayTao')
                          ->paginate(12)
                          ->withQueryString();

        return view('client.post.index', compact('baiViets'));
    }

    // Chi tiết bài viết
    public function show($slug)
    {
        $baiViet = Post::where('Slug', $slug)
            ->where('TrangThai', 1)
            ->firstOrFail();

        return view('client.post.show', compact('baiViet'));
    }
}
