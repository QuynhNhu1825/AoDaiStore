
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Áo Dài Heritage</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Swiper -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto:wght@300;400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        .serif {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-stone-800">

    {{-- HEADER --}}
    @include('partials.client._header')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- LOGIN POPUP --}}
    @include('auth.login')

    {{-- FOOTER --}}
    @include('partials.client._footer')

    {{-- JS MODAL --}}
    <script>
        function openLoginModal() {
            const modal = document.getElementById('loginModal');

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');

            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Toggle password
        document.addEventListener('click', function (e) {
            if (e.target.closest('.toggle-password')) {
                const button = e.target.closest('.toggle-password');
                const wrapper = button.closest('.relative');
                const input = wrapper.querySelector('.password-input');

                if (input.type === 'password') {
                    input.type = 'text';
                    button.textContent = '👁‍🗨️';
                } else {
                    input.type = 'password';
                    button.textContent = '👁';
                }
            }
        });

        // Tự mở login modal khi có ?login=1
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);

            if (params.has('login')) {
                openLoginModal();

                window.history.replaceState(
                    {},
                    document.title,
                    window.location.pathname
                );
            }
        });
    </script>

    {{-- AUTO OPEN LOGIN WHEN ERROR --}}
    @if ($errors->has('TenDangNhap') || $errors->has('password'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            openLoginModal();
        });
    </script>
    @endif

    {{-- ĐỒNG BỘ GIỎ HÀNG SAU ĐĂNG NHẬP --}}
    @if(session('merge_cart_pending'))
    <script>
        document.addEventListener('DOMContentLoaded', async function () {

            let cart = [];

            try {
                cart = JSON.parse(localStorage.getItem('cart') || '[]');
            } catch (error) {
            console.error('LocalStorage giỏ hàng không hợp lệ:', error);
            localStorage.removeItem('cart');
        }

            // Không đồng bộ nếu giỏ hàng trống
            if (!Array.isArray(cart) || cart.length === 0) {
                return;
            }

            try {
                const response = await fetch('{{ route("cart.merge") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    },
                    body: JSON.stringify({
                        items: cart
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {

                    // Chỉ xóa Local Storage khi đồng bộ thành công
                    localStorage.removeItem('cart');

                    console.log('Đồng bộ giỏ hàng thành công!');

                    // Reload để cập nhật số lượng giỏ hàng
                    window.location.reload();

                } else {
                    console.error(
                        'Đồng bộ giỏ hàng thất bại:',
                        result.message
                    );
                }

            } catch (error) {
                console.error('Lỗi đồng bộ giỏ hàng:', error);
            }
        });
    </script>
    @endif

    {{-- TAWK.TO --}}
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {};
        var Tawk_LoadStart = new Date();

        (function () {
            var s1 = document.createElement("script");
            var s0 = document.getElementsByTagName("script")[0];

            s1.async = true;
            s1.src = 'https://embed.tawk.to/696c4b974c20a7197f8c8b23/1jf7geiil';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');

            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

</body>
</html>
