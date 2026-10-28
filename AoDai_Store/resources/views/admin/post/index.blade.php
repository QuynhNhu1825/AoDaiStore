@extends('layouts.admin')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="space-y-6">

    {{-- THỐNG KÊ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center border-l-4 border-indigo-500">
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600 mr-4">
                <i class="fas fa-newspaper fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase">Tổng bài viết</p>
                <p class="text-xl font-bold text-gray-800">
                    {{ $baiViets->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- SEARCH + ACTION --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between gap-4">

            {{-- SEARCH --}}
            <form action="{{ route('admin.baiviet.index') }}" method="GET" class="flex flex-1 gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition"
                        placeholder="Tìm theo tiêu đề bài viết...">
                </div>

                <button type="submit"
                        class="bg-slate-800 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition">
                    Lọc
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.baiviet.index') }}"
                       class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg flex items-center">
                        Xóa lọc
                    </a>
                @endif
            </form>

            {{-- ADD --}}
            <a href="{{ route('admin.baiviet.create') }}"
               class="inline-flex items-center justify-center bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold shadow-md">
                <i class="fas fa-plus-circle mr-2"></i> Thêm bài viết
            </a>
        </div>
    </div>

    {{-- BẢNG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4 border-b text-center">STT</th>
                    <th class="px-6 py-4 border-b">Tiêu đề</th>
                    <th class="px-6 py-4 border-b">Loại bài viết</th>
                    <th class="px-6 py-4 border-b text-center">Trạng thái</th>
                    <th class="px-6 py-4 border-b text-center">Chức năng</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($baiViets as $index => $bv)
                <tr class="hover:bg-indigo-50/40 transition duration-150">
                    <td class="px-6 py-4 text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $bv->TieuDe }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $bv->LoaiBaiViet }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($bv->TrangThai == 1)
                            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Hiển thị
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded-full">
                                Ẩn
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-3 text-sm">

                            {{-- SỬA --}}
                            <a href="{{ route('admin.baiviet.edit', $bv->MaBaiViet) }}"
                               class="flex items-center gap-2 px-3 py-1.5
                                      text-blue-600 bg-blue-50 rounded-lg
                                      hover:bg-blue-100 transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Sửa</span>
                            </a>

                            {{-- XÓA --}}
                            <button type="button"
                                onclick='confirmDelete({{ $bv->MaBaiViet }}, @json($bv->TieuDe))'
                                class="flex items-center gap-2 px-3 py-1.5
                                       text-red-600 bg-red-50 rounded-lg
                                       hover:bg-red-100 transition">
                                <i class="fa-solid fa-trash"></i>
                                <span>Xóa</span>
                            </button>

                            <form id="delete-form-{{ $bv->MaBaiViet }}"
                                  action="{{ route('admin.baiviet.destroy', $bv->MaBaiViet) }}"
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <p>Chưa có bài viết nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Xác nhận xóa',
        text: `Xóa bài viết "${title}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
