@extends('layouts.client')

@section('title', $product->TenSanPham)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        <div class="grid grid-cols-1 gap-4">
            <img
                id="mainImage"
                src="{{ asset('img/products/' . $product->HinhAnh) }}"
                class="w-full h-[520px] object-cover rounded-sm shadow-md cursor-pointer"
                alt="{{ $product->TenSanPham }}"
            >
            <div class="grid grid-cols-4 gap-2">
                <img
                   src="{{ asset('img/products/' . $product->HinhAnh) }}"
                            onclick="changeImage(this.src)"
                            class="w-full h-full object-cover"
                            alt=""
                >         
                @foreach($product->hinhanhsanpham as $img)
                    <div class="w-full aspect-square overflow-hidden border hover:border-stone-800 cursor-pointer">
                        <img
                            src="{{ asset('img/details/' . $img->LinkAnh) }}"
                            onclick="changeImage(this.src)"
                            class="w-full h-full object-cover"
                            alt="Ảnh chi tiết {{ $loop->iteration }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <form action="{{ route('cart.add', $product->MaSanPham) }}" method="POST">
                @csrf

                <div>
                    <nav class="text-xs text-stone-400 mb-2 uppercase tracking-widest">
                        Trang chủ / {{ $product->danhMucs->first()?->TenDanhMuc ?? 'Áo dài' }}
                    </nav>

                    <h1 class="serif text-4xl text-stone-900 leading-tight uppercase">
                        {{ $product->TenSanPham }}
                    </h1>

                    <p id="product-price" class="text-2xl text-red-800 font-bold mt-4">
                        {{ number_format($product->chiTietSanPham->first()?->Gia ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>

                <div class="text-stone-600 text-sm leading-relaxed border-b pb-6 italic">
                    {{ $product->MoTa }}
                </div>

                @php
                    $details = $product->chiTietSanPham;
                    $selectedColorId = $details->first()?->MaMau;
                    $availableColorIds = $details->pluck('MaMau')->unique();
                @endphp

                <div class="mb-5">
                    <div class="font-bold text-sm uppercase text-stone-700 mb-3">
                        Chọn màu sắc:
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach($details->pluck('mauSac')->filter()->unique('MaMau') as $color)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="MaMau"
                                    value="{{ $color->MaMau }}"
                                    class="color-radio peer hidden"
                                    {{ $color->MaMau == $selectedColorId ? 'checked' : '' }}
                                    required
                                >
                                <span class="inline-flex items-center gap-2 border px-3 py-2 text-sm text-stone-700 peer-checked:border-stone-900 peer-checked:bg-stone-900 peer-checked:text-white hover:border-stone-800 transition">
                                    @if(!empty($color->MaHex))
                                        <span class="inline-block w-4 h-4 rounded-full border border-stone-300"
                                              style="background-color: {{ $color->MaHex }}"></span>
                                    @endif
                                    {{ $color->TenMau }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-bold text-sm uppercase text-stone-700">Chọn kích cỡ:</span>
                        <span id="stock-info" class="text-xs font-bold text-red-700 uppercase"></span>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @foreach($allSizes as $s)
                            @php
                                $matchingDetail = $details->first(function ($detail) use ($s, $selectedColorId) {
                                    return (int) $detail->MaSize === (int) $s->MaSize
                                        && (int) $detail->MaMau === (int) $selectedColorId
                                        && (int) $detail->IsDeleted === 0;
                                });
                                $stock = $matchingDetail ? (int) $matchingDetail->SoLuong : 0;
                            @endphp

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="MaSize"
                                    value="{{ $s->MaSize }}"
                                    class="size-radio peer hidden"
                                    data-size="{{ $s->MaSize }}"
                                    {{ $stock <= 0 ? 'disabled' : '' }}
                                    required
                                >
                                <span class="size-label w-14 h-12 border flex items-center justify-center transition relative
                                    peer-checked:bg-stone-800 peer-checked:text-white peer-checked:border-stone-800
                                    {{ $stock <= 0 ? 'bg-stone-50 text-stone-300 cursor-not-allowed opacity-60' : 'hover:border-stone-800 text-stone-700' }}">
                                    {{ $s->TenSize }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="py-4">
                    <span class="font-bold text-sm uppercase text-stone-700 block mb-3">Số lượng:</span>

                    <div class="flex items-center w-32 border border-stone-300">
                        <button type="button" onclick="changeQty(-1)"
                            class="w-10 h-10 flex items-center justify-center hover:bg-stone-100">-</button>

                        <input
                            type="number"
                            name="SoLuong"
                            id="quantity"
                            value="1"
                            min="1"
                            max="1"
                            class="w-12 h-10 text-center bg-transparent font-semibold focus:ring-0"
                        >

                        <button type="button" onclick="changeQty(1)"
                            class="w-10 h-10 flex items-center justify-center hover:bg-stone-100">+</button>
                    </div>
                </div>

                <div class="bg-stone-100 p-4 rounded-sm border-l-4 border-stone-800 my-6">
                    <p class="text-sm font-bold uppercase mb-1">📐 May theo số đo riêng?</p>
                    <p class="text-xs text-stone-500 italic">
                        Để lại ghi chú khi thanh toán hoặc nhắn tin trực tiếp để được tư vấn chi tiết.
                    </p>
                </div>
        
                <div class="flex items-center gap-6">
                    <button type="submit"
                        class="flex-1 bg-stone-900 text-white py-4 font-bold uppercase tracking-widest hover:bg-black">
                        Thêm vào giỏ hàng
                    </button>
        </form>
                    <div class="flex gap-6 text-sm text-stone-500 mt-3">
                        <span>👁 {{ $product->LuotXem }} lượt xem</span>
                        ❤️ <span id="favorite-count">{{ $soLuotThich }}</span> yêu thích
                        <span>
                            ⭐ {{ $avgRating ? number_format($avgRating, 1) : '0.0' }}/5
                        </span>
                    </div>
                <button
                    type="button"
                    id="btnFavorite"
                    data-id="{{ $product->MaSanPham }}"
                    class="w-14 border border-stone-300 flex items-center justify-center hover:bg-stone-50 text-xl">
                    <span id="icon-heart">
                    {{ $isFavorite ? '❤️' : '♡' }}
                </span>
                </button>



                 </div>
         

            <div class="pt-6 border-t">
                <details open class="group">
                    <summary class="flex justify-between items-center font-bold text-sm uppercase py-2 cursor-pointer">
                        Thông tin chi tiết & Bảo quản
                        <span class="group-open:rotate-45 transition">+</span>
                    </summary>

                    <div class="text-sm text-stone-500 space-y-3 leading-relaxed">
                        <p>• <b class="text-stone-700">Chất liệu:</b> {{ $product->chatlieu?->TenChatLieu ?? "Chưa cập nhật" }}</p>
                        <p>
                        <b class="text-stone-700">Màu sắc:</b>
                        {{ $product->chiTietSanPham->first()?->mauSac?->TenMau ?? 'Chưa cập nhật' }}
                        </p>
                        <p>• <b class="text-stone-700">Xuất xứ:</b> {{ $product->chatlieu?->XuatXu ?? "Việt Nam" }}</p>

                        <div class="pt-2 border-t italic text-xs">
                            <b class="not-italic uppercase text-stone-700">Hướng dẫn bảo quản:</b><br>
                            {{ $product->chatlieu?->HuongDanBaoQuan ?? "Chưa cập nhật" }}
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>
{{--  ĐÁNH GIÁ SẢN PHẨM --}}
<div class="max-w-7xl mx-auto px-4 py-10 border-t mt-12">

    <h2 class="text-2xl font-bold mb-6">Đánh giá sản phẩm</h2>

    {{-- DANH SÁCH ĐÁNH GIÁ --}}
    @forelse($dsDanhGia as $dg)
        <div class="border-b py-4">
            <p class="font-semibold">
                {{ $dg->TenDangNhap ?? 'Khách hàng' }}
                <span class="text-yellow-500 ml-2">
                    @for($i=1;$i<=5;$i++)
                        {{ $i <= $dg->SoSao ? '★' : '☆' }}
                    @endfor
                </span>
            </p>

            <p class="text-gray-700 mt-1">
                {{ $dg->NoiDung }}
            </p>

            <p class="text-xs text-gray-400 mt-1">
                {{ \Carbon\Carbon::parse($dg->NgayDanhGia)->format('d/m/Y') }}
            </p>
        </div>
    @empty
        <p class="text-gray-500 italic">Chưa có đánh giá nào.</p>
    @endforelse
    {{-- FORM ĐÁNH GIÁ --}}
    @if(auth()->check() && $daMua)
        <form action="{{ route('rating.store', $product->MaSanPham) }}"
              method="POST" enctype="multipart/form-data"
              class="mt-8 bg-stone-50 p-6 rounded">
            @csrf

            <label class="block font-semibold mb-2">Chọn số sao:</label>
            <select name="SoSao" required class="border p-2 rounded mb-4">
                <option value="">-- Chọn --</option>
                @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}">{{ $i }} sao</option>
                @endfor
            </select>

            <label class="block font-semibold mb-2">Nhận xét:</label>
            <textarea name="NoiDung" rows="4"
                      class="w-full border rounded p-2 mb-4"
                      required></textarea>

            <label class="block font-semibold mb-2">Ảnh (nếu có):</label>
            <input type="file" name="HinhAnh" class="mb-4">

            <button type="submit"
                class="bg-stone-900 text-white px-6 py-2 rounded hover:bg-black">
                Gửi đánh giá
            </button>
        </form>
    @else
        <p class="text-sm italic text-gray-500 mt-6">
            * Chỉ khách hàng đã mua sản phẩm mới được đánh giá
        </p>
    @endif
</div>
{{-- SẢN PHẨM LIÊN QUAN --}}
{{-- SẢN PHẨM LIÊN QUAN --}}
<div class="max-w-7xl mx-auto px-4 py-14 border-t mt-12">
    <h2 class="serif text-2xl font-bold uppercase tracking-wide text-stone-800 mb-6">
        Sản phẩm liên quan
    </h2>

    <div class="related-slider">
        <div class="related-track">

            {{-- Vòng lặp lấy dữ liệu thực tế --}}
            @foreach($relatedProducts as $item)
                <div class="related-item">
                    <a href="{{ route('product.detail', $item->MaSanPham) }}"> {{-- --}}
                        <div class="related-img">
                            <img src="{{ asset('img/products/' . $item->HinhAnh) }}" 
                                 alt="{{ $item->TenSanPham }}" 
                                 class="w-full h-full object-cover"> {{-- --}}
                        </div>

                        <h3 class="related-title">
                            {{ $item->TenSanPham }} {{-- --}}
                        </h3>

                        <p class="related-category">
                            {{ $item->loaisanpham->TenLoaiSP ?? 'Áo dài' }} {{-- --}}
                        </p>

                        <p class="related-price">
                            {{ number_format($item->chiTietSanPham->first()?->Gia ?? 0, 0, ',', '.') }} đ {{-- --}}
                        </p>
                    </a>
                </div>
            @endforeach

            {{-- Nhân đôi dữ liệu để slider chạy mượt (Infinite Loop) --}}
         

        </div>
    </div>
</div>

<script>
    const qtyInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stock-info');
    const colorRadios = document.querySelectorAll('.color-radio');
    const sizeRadios = document.querySelectorAll('.size-radio');

    // Dữ liệu biến thể từ bảng chitietsanpham: mỗi bản ghi gắn với một màu và một size.
    @php
    $productDetails = \App\Models\ProductDetail::query()
        ->where('MaSanPham', $product->MaSanPham)
        ->where('IsDeleted', 0)
        ->get(['MaMau', 'MaSize', 'Gia', 'SoLuong'])
        ->map(fn ($detail) => [
            'MaMau' => (int) $detail->MaMau,
            'MaSize' => (int) $detail->MaSize,
            'Gia' => (float) $detail->Gia,
            'SoLuong' => (int) $detail->SoLuong,
        ])
        ->values()
        ->all();
    @endphp

<script>
    const productDetails = @json($productDetails);
</script>
<script>

    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function getSelectedColor() {
        return document.querySelector('input[name="MaMau"]:checked')?.value;
    }

    function updateVariantOptions() {
        const selectedColor = parseInt(getSelectedColor() || '0', 10);
        let firstAvailableSize = null;

        sizeRadios.forEach(radio => {
            const sizeId = parseInt(radio.value, 10);
            const detail = productDetails.find(item =>
                item.MaMau === selectedColor && item.MaSize === sizeId
            );
            const stock = detail ? detail.SoLuong : 0;
            const label = radio.closest('label');
            const span = label?.querySelector('.size-label');

            radio.dataset.stock = stock;
            radio.dataset.price = detail ? detail.Gia : 0;
            radio.disabled = stock <= 0;

            if (span) {
                span.classList.toggle('opacity-60', stock <= 0);
                span.classList.toggle('text-stone-300', stock <= 0);
                span.classList.toggle('cursor-not-allowed', stock <= 0);
                span.classList.toggle('text-stone-700', stock > 0);
                span.classList.toggle('hover:border-stone-800', stock > 0);
            }

            if (stock > 0 && firstAvailableSize === null) {
                firstAvailableSize = radio;
            }

            if (radio.checked && stock <= 0) {
                radio.checked = false;
            }
        });

        const selectedSize = document.querySelector('input[name="MaSize"]:checked');
        if (!selectedSize && firstAvailableSize) {
            firstAvailableSize.checked = true;
        }

        updateSelectedVariant();
    }

    function updateSelectedVariant() {
        const selectedColor = parseInt(getSelectedColor() || '0', 10);
        const selectedSize = document.querySelector('input[name="MaSize"]:checked');
        const sizeId = selectedSize ? parseInt(selectedSize.value, 10) : 0;
        const detail = productDetails.find(item =>
            item.MaMau === selectedColor && item.MaSize === sizeId
        );

        const stock = detail ? detail.SoLuong : 0;
        qtyInput.max = Math.max(stock, 1);

        if (stock > 0) {
            stockInfo.innerText = `(Còn ${stock} sản phẩm)`;
            if (parseInt(qtyInput.value || '1', 10) > stock) qtyInput.value = 1;
            qtyInput.disabled = false;
        } else {
            stockInfo.innerText = 'Hết hàng';
            qtyInput.value = 1;
            qtyInput.disabled = true;
        }

        const priceElement = document.getElementById('product-price');
        if (priceElement && detail) {
            priceElement.innerText = new Intl.NumberFormat('vi-VN').format(detail.Gia) + ' đ';
        }
    }

    colorRadios.forEach(radio => {
        radio.addEventListener('change', updateVariantOptions);
    });

    sizeRadios.forEach(radio => {
        radio.addEventListener('change', updateSelectedVariant);
    });

    function changeQty(step) {
        const selected = document.querySelector('input[name="MaSize"]:checked');
        if (!selected) {
            alert('Vui lòng chọn màu sắc và kích cỡ trước!');
            return;
        }

        const max = parseInt(selected.dataset.stock || '0', 10);
        let val = parseInt(qtyInput.value || '1', 10) + step;
        if (val < 1) val = 1;
        if (val > max) val = max;
        qtyInput.value = val;
    }

    updateVariantOptions();

    const favoriteButton = document.getElementById('btnFavorite');
    if (favoriteButton) {
        favoriteButton.addEventListener('click', function () {
            const productId = this.dataset.id;
            const icon = document.getElementById('icon-heart');

            fetch(`/favorite/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.status === 401) {
                    alert('Vui lòng đăng nhập để yêu thích sản phẩm!');
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (!data) return;
                icon.innerText = data.liked ? '❤️' : '♡';
                document.getElementById('favorite-count').innerText = data.count;
            })
            .catch(() => alert('Không thể cập nhật yêu thích. Vui lòng thử lại.'));
        });
    }
</script>
@endsection
