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
                    <a class="nav-link text-uppercase" href="<?= BASE_URL ?>?action=client-products"><b>Sản phẩm</b></a>
                </li>
            </ul>

        </div>

        <div>
            <?php if(isset($_SESSION['userLogin'])): ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?= $_SESSION['userLogin']['name'] ?>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="<?= BASE_URL ?>?action=client-view-cart">Giỏ hàng</a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>?action=client-view-order">Đơn hàng</a></li>
                    <li>

                        <?php if($_SESSION['userLogin']['role']=='1'): ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-dashboard">Trang admin</a></li>

                    <?php endif; ?>

                    <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>?action=logout">Logout</a></li>
                </ul>
            </div>
            <?php else: ?>
            <a class="btn btn-outline-primary" href="views\admin\admin.php">Đăng nhập / Đăng ký</a>
            <?php endif; ?>
        </div>
    </nav>

    </div>

</body>

</html>