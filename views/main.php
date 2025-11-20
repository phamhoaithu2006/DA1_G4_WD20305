<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Home' ?></title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #ecececff;
        }

        .text-dark-blue {
            color: #343a40;
        }

        .text-dark-red {
            color: #dc3545;
        }

        .bg-light-gray {
            background-color: #f1f1f1;
        }

        .btn-gray {
            background-color: #6c757d;
            color: white;
        }

        .btn-blue {
            background-color: #007bff;
            color: white;
        }

        .btn-red {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-xxl navbar-dark bg-dark justify-content-between px-5">
        <div class="d-flex item-center">
            <ul class="navbar-nav me-3">
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?= BASE_URL ?>"><b>Trang chủ</b></a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?= BASE_URL ?>?action=client-products"><b>Admin</b></a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?= BASE_URL ?>?action=client-products"><b>HDV</b></a>
                </li>
            </ul>
        </div>

        <div>
            <a class="btn btn-outline-primary" href="<?= BASE_URL ?>?act=admin">Đăng nhập</a>
        </div>
    </nav>

    </div>

</body>

</html>