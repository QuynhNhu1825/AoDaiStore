<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #fdfbf9 0%, #f3ece4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden; 
        }

        /* Blobs trang trí */
        .blob {
            position: absolute;
            width: 40vw;
            height: 40vw;
            background: #f1e4d5;
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.6;
        }
        .blob-1 { top: -10%; left: -10%; }
        .blob-2 { bottom: -10%; right: -10%; background: #e8ded2; }

        /* Card tinh chỉnh */
        .soft-card {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            border-radius: 2rem !important;
            border: none;
            max-height: 90vh;
            overflow-y: auto;
        }

        .soft-card::-webkit-scrollbar { width: 5px; }
        .soft-card::-webkit-scrollbar-thumb { background: #e8ded2; border-radius: 10px; }

        .form-control {
            background-color: #fcfaf8 !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 0, 0.1);
            background-color: #ffffff !important;
        }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container py-4">
        <div class="row justify-content-center g-0">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-5">
                
                <div class="card shadow-lg soft-card">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-4">
                            <div class="d-inline-block p-3 rounded-circle mb-3" style="background-color: rgba(128, 0, 0, 0.08);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16" style="color: #800000;">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </div>
                            <h2 class="fw-bold h4 mb-1" style="color: #5d534a;">ĐĂNG KÝ</h2>
                            <p class="text-muted small">Hãy đăng ký để trải nghiệm dịch vụ</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small border-0 mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="text" name="TenDangNhap" class="form-control border-0 shadow-none" id="TenDangNhap" placeholder="Username" required value="{{ old('TenDangNhap') }}">
                                <label for="TenDangNhap" class="text-muted small">Tên đăng nhập</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="HoTen" class="form-control border-0 shadow-none" id="HoTen" placeholder="Full Name" required value="{{ old('HoTen') }}">
                                <label for="HoTen" class="text-muted small">Họ tên</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="Email" class="form-control border-0 shadow-none" id="Email" placeholder="name@example.com" required value="{{ old('Email') }}">
                                <label for="Email" class="text-muted small">Email</label>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" name="SDT" class="form-control border-0 shadow-none" id="SDT" placeholder="Phone" value="{{ old('SDT') }}">
                                        <label for="SDT" class="text-muted small">Số điện thoại</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="DiaChi" class="form-control border-0 shadow-none" id="DiaChi" placeholder="Address" value="{{ old('DiaChi') }}">
                                <label for="DiaChi" class="text-muted small">Địa chỉ</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="MatKhau" class="form-control border-0 shadow-none" id="MatKhau" placeholder="Password" required>
                                <label for="MatKhau" class="text-muted small">Mật khẩu</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="MatKhau_confirmation" class="form-control border-0 shadow-none" id="confirm_password" placeholder="Confirm Password" required>
                                <label for="confirm_password" class="text-muted small">Nhập lại mật khẩu</label>
                            </div>

                            <button type="submit" class="btn w-100 py-3 rounded-4 fw-bold shadow-sm text-white border-0" style="background-color: #800000;">
                                ĐĂNG KÝ NGAY
                            </button>
                        </form>

                        <div class="text-center mt-4 text-muted small">
                            Đã có tài khoản? <a href="/login" class="fw-bold text-decoration-none" style="color: #800000;">Đăng nhập</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>