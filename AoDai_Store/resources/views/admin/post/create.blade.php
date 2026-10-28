@extends('layouts.admin')

@section('title', 'Thêm Bài Viết Mới')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- QUAY LẠI --}}
    <div class="mb-4">
        <a href="{{ route('admin.baiviet.index') }}"
           class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.baiviet.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">

                {{-- TIÊU ĐỀ --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Tiêu đề bài viết
                    </label>
                    <input type="text"
                           name="TieuDe"
                           value="{{ old('TieuDe') }}"
                           required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none
                                  @error('TieuDe') border-red-500 @enderror"
                           placeholder="Nhập tiêu đề bài viết...">
                    @error('TieuDe')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- LOẠI BÀI VIẾT --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Loại bài viết
                    </label>
                    <select name="LoaiBaiViet"
                            required
                            class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none
                                   @error('LoaiBaiViet') border-red-500 @enderror">
                        <option value="">-- Chọn loại bài viết --</option>
                        <option value="gioi_thieu" {{ old('LoaiBaiViet') == 'gioi_thieu' ? 'selected' : '' }}>
                            Giới thiệu
                        </option>
                        <option value="blog" {{ old('LoaiBaiViet') == 'blog' ? 'selected' : '' }}>
                            Blog
                        </option>
                        <option value="san_pham" {{ old('LoaiBaiViet') == 'san_pham' ? 'selected' : '' }}>
                            Bài viết sản phẩm
                        </option>
                    </select>
                    @error('LoaiBaiViet')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NỘI DUNG --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Nội dung bài viết
                    </label>
                    <textarea name="NoiDung"
                              rows="8"
                              required
                              class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none
                                     @error('NoiDung') border-red-500 @enderror"
                              placeholder="Nhập nội dung bài viết...">{{ old('NoiDung') }}</textarea>
                    @error('NoiDung')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- TRẠNG THÁI --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Trạng thái
                    </label>
                    <select name="TrangThai"
                            class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

            </div>

            {{-- SUBMIT --}}
            <div class="mt-8 border-t pt-6">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold
                               hover:bg-blue-700 shadow-lg transition-all
                               flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> Lưu bài viết
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
