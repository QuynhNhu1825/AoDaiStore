@extends('layouts.client')
@section('title', 'Trang cá nhân')
@section('content')
<div class="max-w-6xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">Trang cá nhân</h2>

    {{-- THÔNG TIN CÁ NHÂN --}}
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h3 class="text-lg font-semibold mb-4">Thông tin cá nhân</h3>

        <div class="grid grid-cols-2 gap-4">
            <div><b>Mã khách hàng:</b> {{ $user->MaTaiKhoan }}</div>
            <div><b>Họ tên:</b> {{ $user->HoTen ?? 'Chưa cập nhật' }}</div>
            <div><b>Email:</b> {{ $user->Email ?? 'Chưa cập nhật' }}</div>
            <div><b>Số điện thoại:</b> {{ $user->SoDienThoai ?? 'Chưa cập nhật' }}</div>
            <div><b>Địa chỉ:</b> {{ $user->DiaChi ?? 'Chưa cập nhật' }}</div>
            <div><b>Ngày đăng ký:</b> {{ $user->CreatedDate->format('d/m/Y') }}</div>
        </div>
    </div>
    {{-- ĐƠN HÀNG --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4">Đơn hàng của tôi</h3>

        {{-- LỌC TRẠNG THÁI --}}
        <form method="GET" class="mb-4 flex gap-2">
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Tất cả trạng thái</option>
                <option value="ChoXacNhan" {{ $status=='ChoXacNhan'?'selected':'' }}>Chờ xác nhận</option>
                <option value="DaXacNhan" {{ $status=='DaXacNhan'?'selected':'' }}>Đã xác nhận</option>
                <option value="DangGiao" {{ $status=='DangGiao'?'selected':'' }}>Đang giao</option>
                <option value="DaGiao" {{ $status=='DaGiao'?'selected':'' }}>Đã giao</option>
                <option value="DaHuy" {{ $status=='DaHuy'?'selected':'' }}>Đã hủy</option>
            </select>

            <button class="bg-slate-800 text-white px-4 py-2 rounded">
                Lọc
            </button>
        </form>

        {{-- BẢNG ĐƠN HÀNG --}}
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Mã đơn hàng</th>
                    <th class="border p-2">Ngày đặt hàng</th>
                    <th class="border p-2">Tổng tiền</th>
                    <th class="border p-2">Trạng thái</th>
                    <th class="border p-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="border p-2">{{ $order->MaHoaDon }}</td>
                    <td class="border p-2">{{ $order->NgayTao }}</td>
                    <td class="border p-2">{{ number_format($order->TongTien) }} đ</td>
                    <td class="border p-2">{{ $order->trang_thai_text }}</td>

                    <td class="border p-2 text-center">
                     @if($order->TrangThai === 'ChoXacNhan')
                    <form action="{{ route('orders.cancel', $order->MaHoaDon) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                    @csrf
                    @method('PATCH')

                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Hủy đơn
                </button>
            </form>
            @elseif($order->TrangThai === 'DangGiao')
            <form action="{{ route('orders.submit', $order->MaHoaDon) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn đã nhận đơn hàng này?')">
                    @csrf
                    @method('PATCH')

                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Nhận hàng
                </button>
            </form>
            @else
            <span class="text-gray-400 italic">—</span>
           @endif
            </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        Chưa có đơn hàng
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex justify-center">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
