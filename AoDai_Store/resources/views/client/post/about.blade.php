@extends('layouts.client')

@section('title', 'Giới thiệu')

@section('content')
<div class="max-w-7xl mx-auto py-12 space-y-16">

    
    <section>
        <h1 class="text-3xl font-bold mb-6">
            {{ $gioiThieu->TieuDe ?? 'Giới thiệu' }}
        </h1>

        <div class="prose max-w-none">
            {!! $gioiThieu->NoiDung ?? '<p>Nội dung đang được cập nhật.</p>' !!}
        </div>
    </section>

    
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Bài viết Blog</h2>
            <a href="{{ route('blog.index') }}"
               class="text-blue-600 hover:underline">
                Xem tất cả →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($blogs as $blog)
                <a href="{{ route('blog.show', $blog->Slug) }}"
                   class="border p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold mb-2">
                        {{ $blog->TieuDe }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($blog->NgayTao)->format('d/m/Y') }}
                    </p>
                </a>
            @empty
                <p class="text-gray-500 italic">
                    Chưa có bài viết blog.
                </p>
            @endforelse
        </div>
    </section>

    
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Bài viết về sản phẩm</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($baiVietSanPham as $bv)
                <a href="{{ route('blog.show', $bv->Slug) }}"
                   class="border p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold mb-2">
                        {{ $bv->TieuDe }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($bv->NgayTao)->format('d/m/Y') }}
                    </p>
                </a>
            @empty
                <p class="text-gray-500 italic">
                    Chưa có bài viết sản phẩm.
                </p>
            @endforelse
        </div>
    </section>

</div>
@endsection
