@extends('layouts.admin')

@section('title', 'Chỉnh sửa liên hệ: ' . $contact->HoTen)

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Nút quay lại --}}
    <div class="mb-4">
        <a href="{{ route('admin.contacts.index') }}"
           class="text-sky-600 hover:underline flex items-center transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách liên hệ
        </a>
    </div>

    {{-- Thẻ nội dung --}}
    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-sky-600">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide">
                Cập nhật thông tin liên hệ
            </h2>
            <p class="text-xs text-gray-500 mt-1 italic">
                Mã liên hệ: #{{ $contact->MaLienHe }}
            </p>
            <p class="text-xs text-gray-500 mt-1 italic">
                Mã khách hàng: {{ $contact->MaTaiKhoan ?? 'Khách hàng vãng lai' }}
            </p>
        </div>

        <form action="{{ route('admin.contacts.update', $contact->MaLienHe) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">

                {{-- Họ tên --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700 uppercase text-xs tracking-widest">
                        Họ tên
                    </label>
                    <input type="text" name="HoTen"
                           value="{{ old('HoTen', $contact->HoTen) }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-sky-500 outline-none transition
                           @error('HoTen') border-red-500 @enderror"
                           placeholder="Nhập họ tên người liên hệ">

                    @error('HoTen')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700 uppercase text-xs tracking-widest">
                        Email
                    </label>
                    <input type="email" name="Email"
                           value="{{ old('Email', $contact->Email) }}" required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-sky-500 outline-none transition
                           @error('Email') border-red-500 @enderror"
                           placeholder="email@example.com">

                    @error('Email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Nội dung --}}
                <div>
                    <label class="block font-semibold mb-2 text-gray-700 uppercase text-xs tracking-widest">
                        Nội dung liên hệ
                    </label>
                    <textarea name="NoiDung" rows="6" required
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-sky-500 outline-none transition shadow-sm
                              @error('NoiDung') border-red-500 @enderror"
                              placeholder="Nội dung liên hệ...">{{ old('NoiDung', $contact->NoiDung) }}</textarea>

                    @error('NoiDung')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Nút --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-4 border-t pt-6">
                <button type="submit"
                        class="flex-1 bg-sky-600 text-white py-3.5 rounded-lg font-bold
                               hover:bg-sky-700 shadow-lg hover:shadow-sky-200 transition-all
                               flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-sync-alt mr-2"></i> Lưu thay đổi
                </button>

                <a href="{{ route('admin.contacts.index') }}"
                   class="px-10 py-3.5 border border-gray-300 text-gray-500 rounded-lg
                          hover:bg-gray-50 transition font-bold text-center">
                    Hủy
                </a>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-sky-50 p-4 rounded-lg flex items-center text-sky-700 border border-sky-100">
        <i class="fas fa-info-circle mr-3"></i>
        <p class="text-xs italic">
            Lưu ý: Việc chỉnh sửa liên hệ chỉ dùng cho mục đích quản lý và hỗ trợ khách hàng.
        </p>
    </div>
</div>
@endsection
