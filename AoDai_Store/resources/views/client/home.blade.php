@extends('layouts.client')

@section('title', 'Nét đẹp truyền thống Việt')

@section('content')
    <section class="css-carousel">
    <div class="slides">

        <div class="slide">
            <img src="https://static.dchic.vn/uploads/media/2025/12/BLOG%20WEB%20MO%20BAN%20SOM%20AO%20DAI-325256125.jpg">
            <div class="content">
                <h1>Dáng Việt Kiêu Sa</h1>
                <p>Tôn vinh vẻ đẹp vĩnh cửu của phụ nữ Việt</p>
                <a href="#product-section">Khám phá ngay</a>
            </div>
        </div>

        <div class="slide">
            <img src="{{ asset('img/logo/download.jpg') }}">
            <div class="content">
                <h1>Thông tin cửa hàng</h1>
                <p>Ưu đãi hấp dẫn dành cho khách hàng thân thiết</p>
                <a href="{{ route('gioithieu') }}">Tìm hiểu ngay</a>
            </div>
        </div>

    </div>
</section>


    <section id="product-section" class="bg-stone-50 border-y border-stone-200 py-8 sticky top-0 z-20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <form id="filter-form" action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:w-1/3">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Tìm tên sản phẩm..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-stone-300 focus:border-red-800 focus:ring-0 rounded-lg text-sm transition-all">
                    <div class="absolute left-3 top-2.5 text-stone-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 w-full md:w-auto">
                    <select name="color" class="filter-select border-stone-300 focus:border-red-800 focus:ring-0 rounded-lg text-sm min-w-[150px] cursor-pointer bg-white">
                        <option value="">Tất cả màu sắc</option>
                        @foreach($data['colors'] as $color)
                            <option value="{{ $color->MaLoaiMau }}" {{ request('color') == $color->MaLoaiMau ? 'selected' : '' }}>
                                {{ $color->TenLoaiMau }}
                            </option>
                        @endforeach
                    </select>

                    <select name="category" class="filter-select border-stone-300 focus:border-red-800 focus:ring-0 rounded-lg text-sm min-w-[150px] cursor-pointer bg-white">
                        <option value="">Tất cả danh mục</option>
                        @foreach($data['categories'] as $cat)
                            <option value="{{ $cat->MaLoaiSP }}" {{ request('category') == $cat->MaLoaiSP ? 'selected' : '' }}>
                                {{ $cat->TenLoaiSP }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" class="filter-select border-stone-300 focus:border-red-800 focus:ring-0 rounded-lg text-sm cursor-pointer bg-white">
                        <option value="">Sắp xếp</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    </select>
                </div>
            </form>
        </div>
    </section>
    <div id="product-data-container">
        <section class="max-w-7xl mx-auto py-16 px-4">
            <div class="text-center mb-12">
                <h2 class="serif text-3xl font-bold text-stone-800 uppercase tracking-widest">
                    Tất Cả Mẫu Thiết Kế
                </h2>
                <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($data['product'] as $s)
                    <div class="group bg-white overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-stone-100 flex flex-col h-full">
                        <div class="relative h-96 overflow-hidden">
                            <img src="{{ asset('img/products/' . $s->HinhAnh) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        </div>

                        <div class="p-6 text-center flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="serif text-md font-semibold text-stone-700 uppercase tracking-tight mb-1">
                                    {{ $s->TenSanPham }}
                                </h3>
                                <p class="text-[10px] text-stone-400 uppercase tracking-[0.1em] mb-3 italic">
                                    {{ $s->chatlieu->TenChatLieu ?? 'Vải lụa truyền thống' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-red-800 font-bold text-lg mb-4">
                                    {{ number_format($s->GiaBan, 0, ',', '.') }}đ
                                </p>
                                <div class="pt-4 border-t border-stone-50">
                                    <a href="{{ route('product.detail', $s->MaSanPham) }}"
                                    class="inline-block border-b border-stone-800 text-[10px]
                                            hover:text-red-700 hover:border-red-700 transition-all
                                            uppercase tracking-[0.2em] pb-1 font-bold">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 text-stone-500 italic">
                        Không tìm thấy mẫu thiết kế nào phù hợp với yêu cầu của bạn.
                    </div>
                @endforelse
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}"
                class="inline-block border border-stone-800 px-8 py-3 text-sm uppercase tracking-widest
                        hover:bg-stone-800 hover:text-white transition-all duration-300 rounded-full font-bold">
                    Xem tất cả
                </a>
            </div>
        </section>
    </div>
    
        {{-- SẢN PHẨM BÁN CHẠY --}}
    <section class="max-w-7xl mx-auto py-16 px-4">
        <div class="text-center mb-12">
            <h2 class="serif text-3xl font-bold text-stone-800 uppercase tracking-widest">
                Sản Phẩm Bán Chạy
            </h2>
            <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($data['bestSellers'] as $s)
                <div class="group bg-white overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-stone-100 flex flex-col h-full">
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ asset('img/products/' . $s->HinhAnh) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>

                    <div class="p-6 text-center flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="serif text-md font-semibold text-stone-700 uppercase tracking-tight mb-1">
                                {{ $s->TenSanPham }}
                            </h3>
                            <p class="text-[10px] text-stone-400 uppercase tracking-[0.1em] mb-3 italic">
                                {{ $s->chatlieu->TenChatLieu ?? 'Vải lụa truyền thống' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-red-800 font-bold text-lg mb-4">
                                {{ number_format($s->GiaBan, 0, ',', '.') }}đ
                            </p>
                            <div class="pt-4 border-t border-stone-50">
                                <a href="{{ route('product.detail', $s->MaSanPham) }}"
                                class="inline-block border-b border-stone-800 text-[10px]
                                        hover:text-red-700 hover:border-red-700 transition-all
                                        uppercase tracking-[0.2em] pb-1 font-bold">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-stone-500 italic">
                    Không có sản phẩm bán chạy.
                </div>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('products.index') }}"
            class="inline-block border border-stone-800 px-8 py-3 text-sm uppercase tracking-widest
                    hover:bg-stone-800 hover:text-white transition-all duration-300 rounded-full font-bold">
                Xem tất cả
            </a>
        </div>
    </section>

    {{-- SẢN PHẨM MỚI --}}
    <section class="max-w-7xl mx-auto py-16 px-4">
        <div class="text-center mb-12">
            <h2 class="serif text-3xl font-bold text-stone-800 uppercase tracking-widest">
                Sản Phẩm Mới
            </h2>
            <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($data['newProducts'] as $s)
                <div class="group bg-white overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-stone-100 flex flex-col h-full">
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ asset('img/products/' . $s->HinhAnh) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>

                    <div class="p-6 text-center flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="serif text-md font-semibold text-stone-700 uppercase tracking-tight mb-1">
                                {{ $s->TenSanPham }}
                            </h3>
                            <p class="text-[10px] text-stone-400 uppercase tracking-[0.1em] mb-3 italic">
                                {{ $s->chatlieu->TenChatLieu ?? 'Vải lụa truyền thống' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-red-800 font-bold text-lg mb-4">
                                {{ number_format($s->GiaBan, 0, ',', '.') }}đ
                            </p>
                            <div class="pt-4 border-t border-stone-50">
                                <a href="{{ route('product.detail', $s->MaSanPham) }}"
                                class="inline-block border-b border-stone-800 text-[10px]
                                        hover:text-red-700 hover:border-red-700 transition-all
                                        uppercase tracking-[0.2em] pb-1 font-bold">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-stone-500 italic">
                    Không có sản phẩm mới.
                </div>
            @endforelse
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('products.index') }}"
            class="inline-block border border-stone-800 px-8 py-3 text-sm uppercase tracking-widest
                    hover:bg-stone-800 hover:text-white transition-all duration-300 rounded-full font-bold">
                Xem tất cả
            </a>
        </div>
    </section>
    

    {{-- KHÁM PHÁ DANH MỤC --}}
    <section class="py-16 bg-stone-50 border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="mb-12">
                <h2 class="serif text-3xl font-bold text-stone-800 uppercase tracking-widest">Khám phá danh mục</h2>
                <div class="h-1 w-20 bg-red-800 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($data['categories']->take(4) as $cat)
                    <a href="{{ route('category.show', $cat->MaLoaiSP) }}"
                    class="relative h-48 group overflow-hidden rounded-xl shadow-md bg-stone-400 flex items-center justify-center">
                        <div class="absolute inset-0 bg-stone-900/40 group-hover:bg-red-900/60 transition-colors duration-500"></div>
                        <span class="relative text-white font-bold uppercase tracking-[0.15em] text-sm px-4 text-center">
                            {{ $cat->TenLoaiSP }}
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                <a href="{{ route('products.category') }}"
                class="inline-block border border-stone-800 px-8 py-3 text-sm uppercase tracking-widest hover:bg-stone-800 hover:text-white transition-all duration-300 rounded-full font-bold">
                    Xem tất cả
                </a>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            /**
             * Hàm xử lý tải sản phẩm bằng Ajax
             */
            function fetchProducts(url) {
                // Lấy tất cả dữ liệu từ form (search, color, category, sort)
                let params = $('#filter-form').serialize();
                
                $.ajax({
                    url: url,
                    type: "GET",
                    data: params,
                    beforeSend: function() { 
                        // Làm mờ danh sách cũ để tạo hiệu ứng đang tải
                        $('#product-data-container').css('opacity', '0.5'); 
                    },
                    success: function(response) {
                        // "Bóc tách" lấy phần nội dung mới từ trang web trả về
                        let newContent = $(response).find('#product-data-container').html();
                        
                        if (newContent) {
                            // Đổ nội dung mới vào container và hiện rõ lại
                            $('#product-data-container').html(newContent).css('opacity', '1');
                        } else {
                            console.error("Không tìm thấy vùng chứa sản phẩm!");
                            $('#product-data-container').css('opacity', '1');
                        }

                        // Cập nhật URL trên thanh địa chỉ để không mất bộ lọc khi F5
                        let cleanUrl = url.split('?')[0]; 
                        window.history.pushState({}, "", cleanUrl + '?' + params);
                    },
                    error: function() {
                        alert('Có lỗi xảy ra trong quá trình tải dữ liệu.');
                        $('#product-data-container').css('opacity', '1');
                    }
                });
            }

            // 1. Khi thay đổi các ô Select (Màu sắc, Danh mục, Sắp xếp)
            $('.filter-select').on('change', function() { 
                fetchProducts("{{ route('home') }}"); 
            });
            
            // 2. Khi gõ vào ô tìm kiếm (Có delay 500ms để tránh gửi yêu cầu liên tục)
            let timer;
            $('input[name="search"]').on('input', function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fetchProducts("{{ route('home') }}");
                }, 500);
            });

            // 3. Xử lý khi nhấn vào các nút Phân trang (Trang 1, 2, 3...)
            $(document).on('click', '.ajax-pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url) {
                    fetchProducts(url);
                }
            });

            // 4. Ngăn form submit theo cách truyền thống (tránh load lại trang khi nhấn Enter)
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                fetchProducts("{{ route('home') }}");
            });
        });
    </script>
@endsection