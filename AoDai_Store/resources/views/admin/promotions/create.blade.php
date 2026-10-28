@extends('layouts.admin')

@section('title', 'Thêm Khuyến mãi mới')

@section('content')
@if (session('success'))
    <div class="max-w-4xl mx-auto mb-6">
        <div class="flex items-center justify-between bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
        <p class="font-bold">Có lỗi xảy ra:</p>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="serif text-2xl font-bold text-stone-800">Tạo mã ưu đãi mới</h2>
            <p class="text-sm text-stone-500">Thiết lập các chương trình giảm giá cho khách hàng</p>
        </div>
        <a href="{{ route('promotions.index') }}" class="text-stone-500 hover:text-stone-800 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('promotions.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Tên chương trình</label>
                    <input type="text" name="TenKhuyenMai" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all"
                        placeholder="Ví dụ: Ưu đãi mùa hè 2024">
                </div>

                

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Số lượng phát hành</label>
                    <input type="number" name="SoLuong" required min="1"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Loại hình ưu đãi</label>
                    <select name="LoaiGiam" id="LoaiGiam" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all">
                        <option value="1">Giảm theo phần trăm (%)</option>
                        <option value="0">Giảm theo số tiền cố định (đ)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Mức giảm</label>
                    <input type="number" name="GiaTriGiam" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Đơn hàng tối thiểu (đ)</label>
                    <input type="number" name="Dieukienkhuyenmai" value="0"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all">
                </div>

                <div id="max_discount_wrapper">
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Giảm tối đa (đ)</label>
                    <input type="number" name="GiamToiDa"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 focus:border-stone-900 outline-none transition-all"
                        placeholder="Bỏ trống nếu không giới hạn">
                </div>

                <div class="md:col-span-2 border-t border-stone-50 pt-4 mt-2">
                    <h4 class="text-sm font-bold text-stone-700 mb-4">Thời gian áp dụng</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] text-stone-400 mb-1 italic">Ngày bắt đầu</label>
                            <input type="date" name="NgayBatDau" required
                                class="w-full px-4 py-2 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] text-stone-400 mb-1 italic">Ngày kết thúc</label>
                            <input type="date" name="NgayKetThuc" required
                                class="w-full px-4 py-2 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Trạng thái ban đầu</label>
                    <div class="flex items-center space-x-4 mt-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="TrangThai" value="1" checked class="w-4 h-4 text-stone-900 border-stone-300 focus:ring-stone-900">
                            <span class="ml-2 text-sm text-stone-600">Kích hoạt ngay</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="TrangThai" value="0" class="w-4 h-4 text-stone-900 border-stone-300 focus:ring-stone-900">
                            <span class="ml-2 text-sm text-stone-600">Tạm khóa</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-3">
                <button type="reset" class="px-6 py-3 rounded-xl text-stone-500 font-bold text-xs uppercase tracking-widest hover:bg-stone-50">Làm mới</button>
                <button type="submit" class="bg-stone-900 text-white px-10 py-3 rounded-xl hover:bg-red-900 transition-all shadow-lg font-bold text-xs uppercase tracking-widest">
                    Lưu chương trình
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const loaiGiamSelect = document.getElementById('LoaiGiam');
    const maxDiscountWrapper = document.getElementById('max_discount_wrapper');

    function toggleMaxDiscount() {
        // Hiện nếu là 1 (%), Ẩn nếu là 0 (tiền mặt)
        if (loaiGiamSelect.value == '1') {
            maxDiscountWrapper.style.display = 'block';
        } else {
            maxDiscountWrapper.style.display = 'none';
        }
    }

    // Lắng nghe sự kiện thay đổi
    loaiGiamSelect.addEventListener('change', toggleMaxDiscount);
    
    // Gọi hàm ngay khi trang vừa load xong
    toggleMaxDiscount();
</script>
@endsection