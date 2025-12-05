<?php
// views/hdv/login.php
session_start();
$error = $_SESSION['hdv_error'] ?? null;
unset($_SESSION['hdv_error']);
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập hướng dẫn viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #B3E5FC, #F0F0F0);
            height: 100vh;
        }

        .card {
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        .card-title {
            text-align: center;
            font-weight: 700;
            color: #333;
        }

        .btn-primary {
            background-color: #5563DE;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #3b4abe;
        }

        .alert {
            border-radius: 0.5rem;
        }

        input.form-control {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Đăng nhập - Hướng dẫn viên</h4>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="post" action="?act=hdv-check-login">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary">Đăng nhập</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>