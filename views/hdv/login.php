<?php
// views/hdv/login.php

// 1. Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Lấy thông báo lỗi (hỗ trợ cả logic cũ và mới)
$error = $_SESSION['error'] ?? $_SESSION['hdv_error'] ?? null;

// 3. Xóa lỗi sau khi đã lấy xong để không hiện lại khi F5
unset($_SESSION['error']);
unset($_SESSION['hdv_error']);

// 4. Xử lý đường dẫn an toàn (tránh lỗi nếu BASE_URL chưa define)
$baseUrl = defined('BASE_URL') ? BASE_URL : '';
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập hệ thống</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }

        .login-image {
            /* Ảnh nền bên trái (chỉ hiện trên PC) */
            background: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center center no-repeat;
            background-size: cover;
            min-height: 500px;
        }

        .login-form-container {
            padding: 3rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 50px;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-1px);
        }

        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            height: auto;
            font-size: 0.9rem;
        }

        .brand-text {
            color: #4e73df;
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .welcome-text {
            color: #5a5c69;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.1rem;
        }

        .logo-img {
            max-height: 50px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card card-login o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block login-image"></div>

                            <div class="col-lg-6 bg-white">
                                <div class="login-form-container">

                                    <div class="text-center">
                                        <img src="https://insacmau.com/wp-content/uploads/2023/02/logo-fpt-polytechnic.png"
                                            alt="Logo" class="logo-img">

                                        <div class="brand-text">TOUR MANAGEMENT</div>
                                        <p class="welcome-text">Chào mừng quay trở lại!</p>
                                    </div>

                                    <?php if ($error): ?>
                                        <div class="alert alert-danger alert-dismissible fade show shadow-sm small"
                                            role="alert">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                                            <?= htmlspecialchars($error) ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" method="POST" action="?act=hdv-check-login">
                                        <div class="mb-3">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Nhập Email" required autofocus>
                                        </div>
                                        <div class="mb-4">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Nhập Mật khẩu" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 d-block shadow-sm">
                                            Đăng nhập
                                        </button>
                                    </form>

                                    <hr class="my-4 opacity-25">

                                    <div class="text-center">
                                        <a class="small text-decoration-none text-secondary" href="#">Quên mật khẩu?</a>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            &copy; 2025 Hệ thống quản lý Tour du lịch
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>