<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-custom {
            background-color: #1f2937;
            padding: 0.7rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-custom .nav-link {
            font-size: 15px;
            font-weight: 600;
            color: #e5e7eb !important;
            text-transform: uppercase;
            margin-right: 1.5rem;
            transition: color 0.3s;
        }

        .navbar-custom .nav-link:hover {
            color: #60a5fa !important;
        }

        .btn-login {
            border-radius: 8px;
            padding: 6px 18px;
            font-weight: 600;
            border: 2px solid #60a5fa;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #60a5fa;
            color: #fff;
            border-color: #60a5fa;
        }

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 0.5rem 1rem;
            }

            .navbar-custom .nav-link {
                margin-right: 1rem;
                font-size: 14px;
            }

            .btn-login {
                padding: 5px 14px;
                font-size: 14px;
            }
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>"><b>Trang chủ</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?act=admin"><b>Admin</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?act=hdv-login"><b>HDV</b></a>
                    </li>
                </ul>

                <div class="d-flex">
                    <a class="btn btn-outline-primary btn-login" href="<?= BASE_URL ?>?act=admin">Đăng nhập</a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>