@extends('layouts.admin')

@section('title', 'Sửa Nhà Cung Cấp')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-4">
        <a href="{{ route('admin.suppliers.index') }}"
           class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.suppliers.update', $supplier->MaNCC) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Tên NCC --}}
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Tên nhà cung cấp</label>
                    <input type="text" name="TenNCC"
                           value="{{ old('TenNCC', $supplier->TenNCC) }}"
                           required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- SĐT --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Số điện thoại</label>
                    <input type="text" name="SDT"
                           value="{{ old('SDT', $supplier->SDT) }}"
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">Email</label>
                    <input type="email" name="Email"
                           value="{{ old('Email', $supplier->Email) }}"
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Địa chỉ --}}
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Địa chỉ</label>
                    <textarea name="DiaChi" rows="3"
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('DiaChi', $supplier->DiaChi) }}</textarea>
                </div>

                {{-- Trạng thái --}}
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">Trạng thái</label>
                    <select name="TrangThai"
                            class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="1" {{ old('TrangThai', $supplier->TrangThai) == 1 ? 'selected' : '' }}>
                            Đang hoạt động
                        </option>
                        <option value="0" {{ old('TrangThai', $supplier->TrangThai) == 0 ? 'selected' : '' }}>
                            Ngưng hợp tác
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-8 border-t pt-6">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg transition-all flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> Cập nhật nhà cung cấp
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
