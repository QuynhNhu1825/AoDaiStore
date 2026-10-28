@extends('layouts.client')

@section('title', 'Giỏ hàng của bạn')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Popup thông báo thanh toán --}}


<section class="max-w-7xl mx-auto py-16 px-4 min-h-screen">
    <div class="text-center mb-12">
        <h2 class="serif text-3xl font-bold text-stone-800 uppercase tracking-widest">Túi hàng của bạn</h2>
        <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
    </div>
    @if(isset($message))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        ⚠️ Vui lòng <a href="{{ route('login') }}" class="underline font-bold">
        đăng nhập</a> để tiến hành thanh toán
    </div>
    @endif
    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-8">
            
            <div class="flex justify-end mb-4">
                <form action="{{ route('cart.clear') }}" method="POST" id="formClearCart">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmClearCart()" class="flex items-center gap-2 text-sm text-stone-400 hover:text-red-700 transition duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="border-b border-transparent group-hover:border-red-700 uppercase tracking-wider font-medium">Xóa sạch giỏ hàng</span>
                    </button>
                </form>
            </div>

            @foreach($cartItems as $item)
            <div class="flex flex-col md:flex-row bg-white shadow-sm border border-stone-100 p-6 group hover:shadow-md transition">
                <div class="w-full md:w-32 h-44 overflow-hidden mb-4 md:mb-0 bg-stone-100">
                    <img src="{{ asset('img/products/' . $item->sanpham->HinhAnh) }}" class="w-full h-full object-cover" alt="{{ $item->sanpham->TenSanPham }}">
                </div>

                <div class="md:ml-8 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="serif text-xl font-semibold text-stone-700 uppercase">{{ $item->sanpham->TenSanPham }}</h3>
                            
                            <form action="{{ Route('cart.remove',$item->sanpham->MaSanPham) }}" method="post" class="form-remove-item">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="size_id" value="{{ $item->MaSize }}">
                                <button type="button" onclick="confirmRemoveItem(this)" class="text-stone-400 hover:text-red-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <div class="mt-3 grid grid-cols-2 gap-y-1 text-sm text-stone-500 italic">
                            <p>Chất liệu: <span class="text-stone-700">{{ $item->sanpham->chatlieu->TenChatLieu ?? 'N/A' }}</span></p>
                            <p>Màu sắc: <span class="text-stone-700">{{ $item->sanpham->loaimau->TenLoaiMau ?? 'N/A' }}</span></p>
                            <p>Kích cỡ: <span class="font-bold text-red-800">{{ $item->size->TenSize ?? 'N/A' }}</span></p>
                            
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                       <div class="flex items-center border border-stone-300 rounded">
                            <button class="btn-update px-3 py-1 hover:bg-stone-100 border-r border-stone-300 text-stone-600" 
                                    data-id="{{ $item->MaSanPham }}" data-type="decrease">-</button>
                            
                            <input type="text" id="qty-{{ $item->MaSanPham }}" value="{{ $item->SoLuong }}" 
                                class="w-12 text-center border-none focus:ring-0 text-stone-700 font-semibold" readonly>
                            
                            <button class="btn-update px-3 py-1 hover:bg-stone-100 border-l border-stone-300 text-stone-600" 
                                    data-id="{{ $item->MaSanPham }}" data-type="increase">+</button>
                        </div>
                        
                        <div class="text-right">
                           
                            <p class="text-red-800 font-bold text-xl">
                                {{ number_format($item->sanpham->GiaBan * $item->SoLuong, 0, ',', '.') }}đ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="mt-8 flex justify-center">
                {{ $cartItems->links() }}
            </div>
            <div class="pt-6 border-t border-stone-200">
                <a href="{{ route('home') }}" class="text-stone-600 hover:text-red-800 transition flex items-center gap-2 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại cửa hàng
                </a>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-stone-50 p-8 border border-stone-200 sticky top-24 shadow-sm">
                <h3 class="serif text-xl font-bold text-stone-800 mb-6 uppercase tracking-widest border-b border-stone-300 pb-4">Tóm tắt đơn hàng</h3>
                
                <div class="space-y-4 text-stone-600">
                    <div class="flex justify-between">
                        <span>Tạm tính ({{ count($cartItems) }} món)</span>
                        <span>{{ number_format($totalPrice, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Phí vận chuyển</span>
                        <span class="text-green-700 font-medium">Miễn phí</span>
                    </div>
                    <div class="border-t border-stone-300 pt-4 flex justify-between text-stone-900 font-bold text-lg uppercase">
                        <span>Tổng thanh toán</span>
                        <span class="text-red-800">{{ number_format($totalPrice, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <a href="{{ route('checkout.home') }}" class="block w-full text-center bg-red-800 hover:bg-red-900 text-white font-bold py-4 mt-8 transition duration-300 uppercase tracking-widest shadow-lg no-underline">
                    Đặt hàng ngay
                </a>

                <div class="mt-8 space-y-4">
                    <div class="flex items-center gap-3 text-xs text-stone-500 italic">
                        <svg class="w-5 h-5 text-stone-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"></path></svg>
                        <span>Thanh toán an toàn qua cổng SSL bảo mật</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-stone-500 italic">
                        <svg class="w-5 h-5 text-stone-400" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM5.88 6.76L4.46 5.34a1 1 0 10-1.42 1.42l1.42 1.42a1 1 0 001.42-1.42zM13.17 6.76a1 1 0 011.42-1.42l1.42 1.42a1 1 0 01-1.42 1.42l-1.42-1.42zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zM3 11a1 1 0 100-2H2a1 1 0 100 2h1z"></path></svg>
                        <span>Hỗ trợ đổi trả trong vòng 7 ngày</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-24 bg-white border border-stone-100 shadow-sm">
        <svg class="mx-auto h-16 w-16 text-stone-200 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <p class="text-stone-500 italic mb-8 text-xl">Giỏ hàng của bạn hiện đang trống.</p>
        <a href="{{ route('home') }}" class="inline-block bg-stone-800 text-white px-10 py-4 hover:bg-stone-900 transition uppercase tracking-widest font-bold">
            Tiếp tục mua sắm
        </a>
    </div>
    @endif
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Cấu hình chung cho Toast (thông báo nhỏ)
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Hàm xác nhận xóa sạch giỏ hàng
function confirmClearCart() {
    Swal.fire({
        title: 'Xóa toàn bộ giỏ hàng?',
        text: "Bạn sẽ không thể hoàn tác hành động này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#991b1b', // red-800
        cancelButtonColor: '#78716c',  // stone-500
        confirmButtonText: 'Đồng ý, xóa hết!',
        cancelButtonText: 'Hủy bỏ'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formClearCart').submit();
        }
    })
}

// Hàm xác nhận xóa 1 sản phẩm
function confirmRemoveItem(button) {
    Swal.fire({
        title: 'Xóa sản phẩm này?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#991b1b',
        cancelButtonColor: '#78716c',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}

$(document).ready(function() {
    $(document).on('click', '.btn-update', function(e) {
        e.preventDefault();
        
        let id = $(this).data('id');
        let type = $(this).data('type');
        let inputField = $('#qty-' + id);

        $.ajax({
            url: "{{ route('update.quantity') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                type: type
            },
            beforeSend: function() {
                // Hiển thị loading nhẹ nếu cần
            },
            success: function(response) {
                if(response.success) {
                    inputField.val(response.new_qty);
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Đã cập nhật số lượng'
                    }).then(() => {
                        location.reload(); 
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Rất tiếc...',
                    text: 'Có lỗi xảy ra khi cập nhật số lượng!',
                    confirmButtonColor: '#991b1b'
                });
            }
        });
    });
});
</script>
@endsection