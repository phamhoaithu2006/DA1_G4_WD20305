<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-xxl navbar-dark bg-dark justify-content-between px-5">
    <img src="https://insacmau.com/wp-content/uploads/2023/02/logo-fpt-polytechnic.png" alt="Logo FPT" width="150"
        class="mb-4">

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
</nav>
<div class="d-flex">

    <!-- Sidebar -->
    <div style="width: 240px; background: #f8f9fa; min-height: 100vh;" class="p-3 border-end">

        <div class="list-group" style="margin-top: 20px;">
            <a href="<?= BASE_URL ?>?act=admin" class="list-group-item list-group-item-action">Tổng quát</a>
            <hr>
            <a href="<?= BASE_URL ?>?act=category" class="list-group-item list-group-item-action">Quản lý tour</a>
            <a href="<?= BASE_URL ?>?act=booking-list" class="list-group-item list-group-item-action">Quản lý
                booking</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý khách hàng</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý nhân sự</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý đối tác và nhà cung cấp</a>
            <a href="#" class="list-group-item list-group-item-action">Báo cáo</a>

            <a href="#" class="list-group-item list-group-item-action">Quản lý booking</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý và điều hành tour</a>
            <a href="#" class="list-group-item list-group-item-action">Báo cáo vận hành tour</a>
        </div>
        <div>
            <hr>
            <a href="<?= BASE_URL ?>"><button class="btn btn-primary mt-auto">Đăng xuất</button></a>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>