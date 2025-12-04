<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<nav class="navbar navbar-expand-xxl px-4" style="background: #0f1a2b;">
    <img src="https://insacmau.com/wp-content/uploads/2023/02/logo-fpt-polytechnic.png"
        alt="Logo FPT" width="150" class="me-4">

    <div class="d-flex ms-auto align-items-center">
        <ul class="navbar-nav me-3">
            <li class="nav-item">
                <a class="nav-link text-uppercase fw-bold text-light" href="<?= BASE_URL ?>?act=admin">
                    <i class="bi bi-house-door me-1"></i> Trang chủ
                </a>
            </li>
        </ul>

        <ul class="navbar-nav me-3">
            <li class="nav-item">
                <a class="nav-link text-uppercase fw-bold text-light" href="<?= BASE_URL ?>?act=dashboard">
                    <i class="bi bi-speedometer2 me-1"></i> Admin
                </a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-uppercase fw-bold text-light" href="<?= BASE_URL ?>?act=hdv-login">
                    <i class="bi bi-person-badge me-1"></i> HDV
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .nav-link {
        padding: 10px 14px !important;
        border-radius: 8px;
        transition: 0.25s;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ff6600 !important;
        transform: translateY(-2px);
    }
</style>