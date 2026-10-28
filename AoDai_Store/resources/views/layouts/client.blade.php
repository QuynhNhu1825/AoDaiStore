<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Áo Dài Heritage</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto:wght@300;400;700&display=swap');
        body { font-family: 'Roboto', sans-serif; }
        .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>

<body class="bg-slate-50 text-stone-800">

    {{-- HEADER --}}
    @include('partials.client._header')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- LOGIN POPUP (PHẢI Ở NGOÀI MAIN) --}}
    @include('auth.login')

    {{-- FOOTER --}}
    @include('partials.client._footer')

    {{-- JS MODAL --}}
    <script>
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.addEventListener("click", function (e) {
            if (e.target.closest(".toggle-password")) {
                const wrapper = e.target.closest(".relative");
                const input = wrapper.querySelector(".password-input");

                if (input.type === "password") {
                    input.type = "text";
                    e.target.textContent = "👁‍🗨️";
                } else {
                    input.type = "password";
                    e.target.textContent = "👁";
                }
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('login')) {
                openLoginModal();

                // XÓA ?login khỏi URL (tránh bật lại khi refresh)
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>

    {{-- AUTO OPEN WHEN LOGIN ERROR --}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', openLoginModal);
    </script>
    @endif

    {{-- TAWK.TO --}}
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/696c4b974c20a7197f8c8b23/1jf7geiil';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>

</body>
</html>