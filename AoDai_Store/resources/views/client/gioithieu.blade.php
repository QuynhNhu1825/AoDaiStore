@extends('layouts.client')

@section('content')
<div class="bg-stone-50 min-h-screen">
    <section class="bg-stone-900 text-white py-20 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <img
                src="{{ asset('img/logo/logo.jpg') }}"
                alt="Áo Dài Heritage"
                class="w-24 h-24 object-cover rounded-full mx-auto mb-6"
            >

            <h1 class="text-4xl md:text-5xl font-serif mb-6">
                ÁO DÀI HERITAGE
            </h1>

            <p class="text-lg leading-relaxed text-stone-300">
                Gìn giữ nét đẹp truyền thống, tôn vinh vẻ đẹp người phụ nữ Việt Nam.
            </p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-serif text-stone-900 mb-6">
                    Câu chuyện của chúng tôi
                </h2>

                <p class="text-stone-600 leading-8 mb-4">
                    Áo Dài Heritage được xây dựng với mong muốn gìn giữ
                    và lan tỏa vẻ đẹp của tà áo dài Việt Nam. Chúng tôi
                    hướng đến những thiết kế kết hợp hài hòa giữa nét đẹp
                    truyền thống và phong cách hiện đại.
                </p>

                <p class="text-stone-600 leading-8">
                    Mỗi sản phẩm đều hướng đến sự tinh tế, duyên dáng
                    và phù hợp với nhiều dịp khác nhau, từ những buổi
                    lễ trang trọng đến các hoạt động thường ngày.
                </p>
            </div>

            <div class="bg-stone-200 rounded-lg p-10 text-center">
                <h3 class="text-2xl font-serif text-stone-900 mb-4">
                    Giá trị cốt lõi
                </h3>

                <div class="space-y-4 text-stone-700">
                    <p>✨ Tôn vinh vẻ đẹp truyền thống</p>
                    <p>✨ Chú trọng chất lượng sản phẩm</p>
                    <p>✨ Đề cao sự tinh tế trong thiết kế</p>
                    <p>✨ Mang đến trải nghiệm mua sắm tốt nhất</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-serif text-stone-900 mb-6">
                Sản phẩm của chúng tôi
            </h2>

            <p class="text-stone-600 leading-8 max-w-3xl mx-auto mb-8">
                Khám phá các mẫu áo dài truyền thống, áo dài cách tân
                và những thiết kế phù hợp với nhiều phong cách khác nhau.
                Áo Dài Heritage mong muốn đồng hành cùng bạn trong những
                khoảnh khắc đáng nhớ.
            </p>

            <a
                href="{{ url('/') }}"
                class="inline-block bg-red-900 text-white px-8 py-3 rounded hover:bg-red-800 transition"
            >
                Khám phá sản phẩm
            </a>
        </div>
    </section>
</div>
@endsection