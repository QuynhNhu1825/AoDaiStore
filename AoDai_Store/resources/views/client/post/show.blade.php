@extends('layouts.client')

@section('title', $baiViet->TieuDe)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">

    {{-- TIÊU ĐỀ --}}
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
        {{ $baiViet->TieuDe }}
    </h1>

    {{-- NGÀY ĐĂNG --}}
    <p class="text-sm text-gray-500 mb-8">
        Ngày đăng:
        {{ \Carbon\Carbon::parse($baiViet->NgayTao)->format('d/m/Y') }}
    </p>

    {{-- NỘI DUNG --}}
    <div class="prose max-w-none leading-relaxed">
        {!! $baiViet->NoiDung !!}
    </div>

    {{-- QUAY LẠI --}}
<div class="mt-12 flex flex-col sm:flex-row gap-4">

    {{-- Quay lại Blog --}}
    <a href="{{ route('blog.index') }}"
       class="inline-flex items-center justify-center px-5 py-2.5
              border border-gray-300 text-gray-700 rounded-lg
              hover:bg-gray-100 transition">
        ← Quay lại Blog
    </a>

    {{-- Quay lại Giới thiệu --}}
    <a href="{{ route('gioithieu') }}"
       class="inline-flex items-center justify-center px-5 py-2.5
              border border-blue-600 text-blue-600 rounded-lg
              hover:bg-blue-50 transition">
        ← Quay lại Trang Giới thiệu
    </a>

</div>


</div>
@endsection
