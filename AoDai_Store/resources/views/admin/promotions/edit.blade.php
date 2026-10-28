@extends('layouts.admin')

@section('title', 'Chỉnh sửa Khuyến mãi')

@section('content')
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
            <h2 class="serif text-2xl font-bold text-stone-800">Cập nhật ưu đãi</h2>
            <p class="text-sm text-stone-500">Đang chỉnh sửa: <span class="text-red-700 font-bold uppercase">{{ $promotion->MaCode }}</span></p>
        </div>
        <a href="{{ route('promotions.index') }}" class="text-stone-500 hover:text-stone-800 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('promotions.update', $promotion->MaKhuyenMai) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Tên chương trình</label>
                    <input type="text" name="TenKhuyenMai" value="{{ $promotion->TenKhuyenMai }}" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none transition-all">
                </div>

                

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Số lượng còn lại</label>
                    <input type="number" name="SoLuong" value="{{ $promotion->SoLuong }}" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Loại hình ưu đãi</label>
                    <select name="LoaiGiam" id="LoaiGiamEdit" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none">
                        <option value="1" {{ $promotion->LoaiGiam == 1 ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                        <option value="0" {{ $promotion->LoaiGiam == 0 ? 'selected' : '' }}>Giảm theo số tiền cố định (đ)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Mức giảm</label>
                    <input type="number" name="GiaTriGiam" value="{{ $promotion->GiaTriGiam }}" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none transition-all">
                </div>

                <div id="max_discount_wrapper_edit" style="{{ $promotion->LoaiGiam == 0 ? 'display:none' : '' }}">
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">Giảm tối đa (đ)</label>
                    <input type="number" name="GiamToiDa" value="{{ $promotion->GiamToiDa }}"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none transition-all">
                </div>

                <div class="md:col-span-2 border-t border-stone-50 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] text-stone-400 mb-1">Ngày bắt đầu</label>
                            <input type="date" name="NgayBatDau" value="{{ date('Y-m-d', strtotime($promotion->NgayBatDau)) }}" required
                                class="w-full px-4 py-2 rounded-xl border border-stone-200">
                        </div>
                        <div>
                            <label class="block text-[10px] text-stone-400 mb-1">Ngày kết thúc</label>
                            <input type="date" name="NgayKetThuc" value="{{ date('Y-m-d', strtotime($promotion->NgayKetThuc)) }}" required
                                class="w-full px-4 py-2 rounded-xl border border-stone-200">
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-[11px] uppercase tracking-widest font-bold text-stone-400 mb-2">
                    Đơn hàng tối thiểu (đ)
                </label>
                <input type="number"
                    name="Dieukienkhuyenmai"
                    value="{{ $promotion->Dieukienkhuyenmai }}"
                    min="0"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-stone-900 outline-none transition-all">
            </div>

            <div class="mt-10 flex justify-end space-x-3">
                <button type="submit" class="bg-stone-900 text-white px-10 py-3 rounded-xl hover:bg-stone-800 transition-all shadow-lg font-bold text-xs uppercase tracking-widest">
                    Cập nhật thay đổi
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('LoaiGiamEdit').addEventListener('change', function() {
        document.getElementById('max_discount_wrapper_edit').style.display = this.value == '1' ? 'block' : 'none';
    });
</script>
@endsection