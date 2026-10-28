@extends('layouts.admin')

@section('title', 'Danh sách Liên hệ')

@section('content')
<div class="space-y-6">

    {{-- THỐNG KÊ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center border-l-4 border-sky-500">
            <div class="p-3 bg-sky-100 rounded-full text-sky-600 mr-4">
                <i class="fas fa-envelope fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase">Tổng số liên hệ</p>
                <p class="text-xl font-bold text-gray-800">{{ $contacts->count() }}</p>
            </div>
        </div>
    </div>

    {{-- BẢNG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                    <th class="px-6 py-4">Người gửi</th>
                    <th class="px-6 py-4">Mã khách hàng</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Nội dung</th>
                    <th class="px-6 py-4">Ngày tạo</th>
                    <th class="px-6 py-4 text-center">Chức năng</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($contacts as $item)
                    <tr class="hover:bg-sky-50/40 transition">

                        {{-- NGƯỜI GỬI --}}
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ $item->HoTen }}</p>
                            <p class="text-xs text-gray-400 font-mono">ID: {{ $item->MaLienHe }}</p>
                        </td>
                        {{-- MÃ KHÁCH HÀNG --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if ($item->MaTaiKhoan)
                                {{ $item->MaTaiKhoan }}
                            @else
                                <span class="text-gray-400 italic">Khách hàng vãng lai</span>
                            @endif
                        </td>

                        {{-- EMAIL --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->Email }}
                        </td>

                        {{-- NỘI DUNG --}}
                        <td class="px-6 py-4 text-sm text-gray-500 italic">
                            {{ \Illuminate\Support\Str::limit($item->NoiDung, 60) }}
                        </td>

                        {{-- NGÀY --}}
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->NgayTao)->format('d/m/Y') }}
                        </td>

                        {{-- CHỨC NĂNG --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-center space-x-2">

                                <a href="{{ route('admin.contacts.edit', $item->MaLienHe) }}"
                                   class="flex items-center px-3 py-2 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                    <i class="fas fa-edit mr-1"></i> Sửa
                                </a>

                                <button type="button"onclick='confirmDelete({{ $item->MaLienHe }}, @json($item->TenLienHe))'
                                    class="flex items-center px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                    <i class="fas fa-trash mr-1"></i> Xóa
                                </button>

                                <form id="delete-form-{{ $item->MaLienHe }}"
                                      action="{{ route('admin.contacts.destroy', $item->MaLienHe) }}"
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
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Chưa có liên hệ nào</p>
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
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Xác nhận xóa',
        text: `Bạn có chắc muốn xóa liên hệ không?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}
</script>
@endsection
