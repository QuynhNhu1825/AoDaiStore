@extends('layouts.admin')

@section('title', 'Quản lý Khuyến mãi')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-red-50 rounded-xl text-red-600 mr-4">
                <i class="fas fa-ticket-alt fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Tổng chương trình</p>
                <p class="text-xl font-bold text-gray-800">{{ $promotions->total() }}</p>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex items-center">
            <div class="p-3 bg-green-50 rounded-xl text-green-600 mr-4">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Đang chạy</p>
                {{-- Lưu ý: Nên truyền $activeCount từ Controller để con số chính xác trên toàn hệ thống --}}
                <p class="text-xl font-bold text-gray-800">{{ $activeCount ?? $promotions->where('TrangThai', 1)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-50 flex flex-col md:flex-row justify-between items-center gap-4">
        <h3 class="serif text-xl font-bold text-stone-800 ml-2 italic">Danh sách mã ưu đãi</h3>
        <a href="{{ route('promotions.create') }}" class="inline-flex items-center bg-stone-900 text-white px-6 py-3 rounded-xl hover:bg-red-900 transition-all duration-300 font-semibold shadow-lg text-xs uppercase tracking-widest">
            <i class="fas fa-plus-circle mr-2"></i> Thêm khuyến mãi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="bg-stone-50/50 p-4 border-b border-stone-100">
            <form action="{{ route('promotions.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[250px]">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-stone-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="block w-full pl-9 pr-3 py-2 border border-stone-200 rounded-xl focus:ring-stone-500 focus:border-stone-500 text-sm" 
                        placeholder="Tìm tên hoặc mã code...">
                </div>

                <select name="loai_giam" class="border border-stone-200 rounded-xl px-4 py-2 text-sm focus:ring-stone-500 focus:border-stone-500 text-stone-600">
                    <option value="">Tất cả loại ưu đãi</option>
                    <option value="1" {{ request('loai_giam') == '1' ? 'selected' : '' }}>Giảm theo %</option>
                    <option value="0" {{ request('loai_giam') == '0' ? 'selected' : '' }}>Giảm theo số tiền</option>
                </select>

                <select name="status" class="border border-stone-200 rounded-xl px-4 py-2 text-sm focus:ring-stone-500 focus:border-stone-500 text-stone-600">
                    <option value="">Mọi trạng thái</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang chạy</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Đã dừng</option>
                </select>

                <button type="submit" class="bg-stone-800 text-white px-5 py-2 rounded-xl hover:bg-stone-700 transition-colors text-xs font-bold uppercase tracking-wider">
                    Lọc
                </button>
                
                @if(request()->anyFilled(['search', 'loai_giam', 'status']))
                    <a href="{{ route('promotions.index') }}" class="text-stone-400 hover:text-red-600 text-xs font-bold uppercase tracking-wider ml-2">
                        Xóa lọc
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50/50 text-stone-500 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-stone-100">
                        <th class="px-6 py-5">Chi tiết Khuyến mãi</th>
                        <th class="px-6 py-5 text-center">Mức ưu đãi</th>
                        <th class="px-6 py-5 text-center">Số lượng</th>
                        <th class="px-6 py-5 text-center">Thời hạn</th>
                        <th class="px-6 py-5 text-center">Trạng thái</th>
                        <th class="px-6 py-5 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($promotions as $promotion)
                    <tr class="hover:bg-stone-50/30 transition duration-150 group">
                        <td class="px-6 py-5">
                            <p class="font-bold text-stone-800 text-sm group-hover:text-red-800 transition-colors uppercase tracking-tight">{{ $promotion->TenKhuyenMai }}</p>
                            <p class="text-[10px] text-stone-400 mt-1">
                                <i class="fas fa-shopping-cart mr-1"></i> Đơn tối thiểu: 
                                <span class="text-stone-600 font-bold">{{ number_format($promotion->Dieukienkhuyenmai, 0, ',', '.') }}đ</span>
                            </p>
                        </td>
                        
                        <td class="px-6 py-5 text-center">
                            @if($promotion->LoaiGiam == 1) 
                                <div class="flex flex-col items-center">
                                    <span class="text-red-700 font-bold text-base">{{ $promotion->GiaTriGiam }}%</span>
                                    @if($promotion->GiamToiDa)
                                        <span class="text-[9px] text-stone-400 whitespace-nowrap">Tối đa: {{ number_format($promotion->GiamToiDa, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                            @else 
                                <span class="text-stone-800 font-bold text-sm">-{{ number_format($promotion->GiaTriGiam, 0, ',', '.') }}đ</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-700 rounded-md">
                                {{ $promotion->SoLuong }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center text-[10px] text-stone-500 font-medium">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-green-600 font-bold">{{ date('d/m/Y', strtotime($promotion->NgayBatDau)) }}</span>
                                <span class="text-stone-300">đến</span>
                                <span class="text-red-600 font-bold">{{ date('d/m/Y', strtotime($promotion->NgayKetThuc)) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($promotion->TrangThai == 1)
                                <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-[9px] font-bold uppercase tracking-wider border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span> Đang chạy
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-stone-100 text-stone-400 rounded-full text-[9px] font-bold uppercase tracking-wider border border-stone-200">
                                    <span class="w-1.5 h-1.5 bg-stone-400 rounded-full mr-2"></span> Tạm khóa
                                </span>
                            @endif
                        </td>
                       
                        <td class="px-6 py-5">
                            <div class="flex justify-end space-x-3">

                                {{-- Sửa --}}
                                <a href="{{ route('promotions.edit', $promotion->MaKhuyenMai) }}"
                                class="text-stone-400 hover:text-blue-600 transition-all transform hover:scale-110" 
                                 title="Sửa"
                                 >
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>

                                {{-- Xóa --}}
                                @if ($promotion->TrangThai==1)
                                <form id="delete-form-{{ $promotion->MaKhuyenMai }}" 
                                action="{{ route('promotions.destroy', $promotion->MaKhuyenMai) }}" 
                                method="POST">
                                @csrf
                                @method('DELETE')
                                
                                <button type="button"
                                        onclick="confirmDelete('{{ $promotion->MaKhuyenMai }}', '{{ $promotion->TenKhuyenMai }}')"
                                        class="text-stone-400 hover:text-red-700 transition-all transform hover:scale-110" 
                                        title="Dừng khuyến mãi">
                                    <i class="fas fa-trash-alt text-xs pointer-events-none"></i>
                                </button>
                            </form>
                                    
                                @endif

                                {{-- Khôi phục --}}
                                @if ($promotion->TrangThai==0)
                                    <form action="{{ route('promotions.restore', $promotion->MaKhuyenMai) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-stone-400 hover:text-green-600 transition-all transform hover:scale-110"
                                                title="Khôi phục">
                                            <i class="fas fa-undo text-xs"></i>
                                        </button>
                                    </form>
                                @endif

                               
                            </div>
                        </td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center text-stone-400 italic">Không tìm thấy dữ liệu phù hợp.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{-- .withQueryString() giúp giữ lại các tham số lọc khi chuyển trang --}}
        {{ $promotions->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: '<span class="serif">Xác nhận gỡ bỏ</span>',
            html: `Mã ưu đãi <b>${name}</b> sẽ bị tạm dừng?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#1c1917',
            cancelButtonColor: '#f5f5f4',
            customClass: {
                confirmButton: 'text-white px-6 py-2 rounded-xl font-bold',
                cancelButton: 'text-stone-600 px-6 py-2 rounded-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-' + id).submit();
            }
        })
    }
</script>
@endsection