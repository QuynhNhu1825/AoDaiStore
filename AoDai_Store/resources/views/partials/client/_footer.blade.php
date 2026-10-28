<footer class="bg-stone-900 text-stone-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <div>
                <img src="{{ asset('img/logo/logo.jpg') }}" alt="Logo"  class="w-16 h-auto mb-4">
                <h3 class="serif text-2xl text-white mb-6 tracking-wider">ÁO DÀI HERITAGE</h3>
                <p class="text-sm leading-relaxed mb-6">
                    Sứ mệnh của chúng tôi là gìn giữ và tôn vinh nét đẹp vĩnh cửu của chiếc Áo dài Việt Nam thông qua những thiết kế tinh xảo và chất liệu cao cấp nhất.
                </p>
                <p class="text-sm mb-1">
                    Địa chỉ: {{ $infoWeb->DiaChiShop }}
                </p>

                <p class="text-sm leading-relaxed">
                    Hotline:
                    <a href="tel:{{ preg_replace('/\s+/', '', $infoWeb->SoDienThoai) }}"
                    class="hover:text-white transition">
                        {{ $infoWeb->SoDienThoai }}
                    </a>
                </p>

                <p class="text-sm leading-relaxed">
                    Email:
                    <a href="mailto:{{ $infoWeb->Email }}"
                    class="hover:text-white transition">
                        {{ $infoWeb->Email }}
                    </a>
                </p>

                <p class="text-sm leading-relaxed">
                    Thời gian mở cửa:
                    <span class="font-medium">
                        {{ $infoWeb->GioMoCua }}
                    </span>
                </p>

            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-widest text-sm mb-6 border-b border-stone-700 pb-2 inline-block">Khám phá</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="#" class="hover:text-white transition">Bộ sưu tập mới nhất</a></li>
                    <li><a href="#" class="hover:text-white transition">Áo dài Tết 2026</a></li>
                    <li><a href="#" class="hover:text-white transition">Áo dài truyền thống</a></li>
                    <li><a href="#" class="hover:text-white transition">Áo dài cách tân</a></li>
                    <li><a href="#" class="hover:text-white transition">Dịch vụ may đo riêng</a></li>
                    <li><a href="#" class="hover:text-white transition">Chương trình khuyến mãi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-widest text-sm mb-6 border-b border-stone-700 pb-2 inline-block">Hỗ trợ khách hàng</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="#" class="hover:text-white transition">Hướng dẫn chọn kích cỡ (Size)</a></li>
                    <li><a href="#" class="hover:text-white transition">Hướng dẫn giặt là</a></li>
                    <li><a href="#" class="hover:text-white transition">Chính sách vận chuyển</a></li>
                    <li><a href="#" class="hover:text-white transition">Chính sách đổi trả</a></li>
                    <li><a href="#" class="hover:text-white transition">Các phương thức thanh toán</a></li>
                    <li><a href="#" class="hover:text-white transition">Câu hỏi thường gặp (FAQs)</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white uppercase tracking-widest text-sm mb-6 border-b border-stone-700 pb-2 inline-block">Bản tin</h4>
                <p class="text-sm mb-4">Để lại email để nhận thông báo về các bộ sưu tập mới nhất và ưu đãi đặc biệt.</p>
                <form class="flex">
                    <input type="email" placeholder="Email của bạn..." class="bg-stone-800 border-none px-4 py-2 w-full text-sm focus:ring-1 focus:ring-red-800 outline-none">
                    <button class="bg-red-900 text-white px-4 py-2 hover:bg-red-800 transition">Gửi</button>
                </form>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-4">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                            <img src="{{ asset('img/logo/Facebook-logo.png') }}" alt="Facebook" class="w-15 h-10 object-contain">
                        </a>

                        <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                            <img src="{{ asset('img/logo/ins.png') }}" alt="Instagram" class="w-8 h-8 object-contain">
                        </a>

                        <a href="https://www.tiktok.com" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                            <img src="{{ asset('img/logo/tiktok2.png') }}" alt="TikTok" class="w-8 h-8 object-contain">
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <div class="border-t border-stone-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs">
            <p>&copy; Bản quyền thuộc về Heritage - Designed with ❤️ in Vietnam.</p>
            <div class="mt-4 md:mt-0 flex space-x-6">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" class="h-4 grayscale hover:grayscale-0 transition opacity-50" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" class="h-4 grayscale hover:grayscale-0 transition opacity-50" alt="Mastercard">
            </div>
        </div>
    </div>
</footer>