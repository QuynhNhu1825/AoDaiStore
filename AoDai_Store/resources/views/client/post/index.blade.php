@extends('layouts.client')

@section('title', 'Tất cả bài viết')

@section('content')
<div class="max-w-7xl mx-auto py-12">

    {{-- QUAY LẠI GIỚI THIỆU --}}
    <div class="mb-8">
        <a href="{{ route('gioithieu') }}"
           class="inline-flex items-center text-blue-600 hover:underline">
            ← Quay lại Trang Giới thiệu
        </a>
    </div>
{{-- TÌM KIẾM --}}
<form method="GET" class="mb-10 flex gap-3 max-w-xl">
    <input type="text"
           name="keyword"
           value="{{ request('keyword') }}"
           placeholder="Tìm bài viết..."
           class="flex-1 border rounded-lg px-4 py-2
                  focus:ring-2 focus:ring-blue-500 outline-none">

    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg
                   hover:bg-blue-700 transition">
        Tìm
    </button>
</form>

    {{--BLOG--}}
    <h2 class="text-2xl font-bold mb-6">Bài viết Blog</h2>

    @php
        $blogs = $baiViets->where('LoaiBaiViet', 'blog');
    @endphp

    @if($blogs->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($blogs as $bv)
                <a href="{{ route('blog.show', $bv->Slug) }}"
                   class="border p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold mb-2">
                        {{ $bv->TieuDe }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($bv->NgayTao)->format('d/m/Y') }}
                    </p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic mb-12">
            Chưa có bài viết blog.
        </p>
    @endif

    {{--SẢN PHẨM--}}
    <h2 class="text-2xl font-bold mb-6">Bài viết về sản phẩm</h2>

    @php
        $sanPhams = $baiViets->where('LoaiBaiViet', 'san_pham');
    @endphp

    @if($sanPhams->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($sanPhams as $bv)
                <a href="{{ route('blog.show', $bv->Slug) }}"
                   class="border p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold mb-2">
                        {{ $bv->TieuDe }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($bv->NgayTao)->format('d/m/Y') }}
                    </p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic mb-12">
            Chưa có bài viết sản phẩm.
        </p>
    @endif

    {{-- PHÂN TRANG --}}
    <div class="mt-6">
        {{ $baiViets->links() }}
    </div>

</div>
@endsection
