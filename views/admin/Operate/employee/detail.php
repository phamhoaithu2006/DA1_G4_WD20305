<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="?act=employees" class="text-decoration-none">Nhân sự</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hồ sơ cá nhân</li>
                </ol>
            </nav>
            <a href="?act=employees" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary-subtle" style="height: 120px;"></div>

                    <div class="card-body px-5 pb-5 position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <div class="rounded-circle bg-white p-1 shadow-sm">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold display-3"
                                    style="width: 120px; height: 120px;">
                                    <?= strtoupper(substr($employee['FullName'] ?? 'U', 0, 1)) ?>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5 pt-3 mb-4">
                            <h3 class="fw-bold text-dark mb-1"><?= htmlspecialchars($employee['FullName']) ?></h3>
                            <span class="badge bg-info-subtle text-info-emphasis px-3 py-2 rounded-pill fs-6 mb-3">
                                <?= htmlspecialchars($employee['Role']) ?>
                            </span>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="tel:<?= htmlspecialchars($employee['Phone']) ?>"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-telephone-fill me-1"></i> Gọi điện
                                </a>
                                <a href="mailto:<?= htmlspecialchars($employee['Email']) ?>"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bi bi-envelope-fill me-1"></i> Gửi Email
                                </a>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-4 h-100">
                                    <h6 class="text-uppercase text-secondary fw-bold small mb-3">Thông tin liên hệ</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-3 d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary"><i
                                                    class="bi bi-telephone"></i></div>
                                            <div>
                                                <small class="text-muted d-block">Điện thoại</small>
                                                <span
                                                    class="fw-medium"><?= htmlspecialchars($employee['Phone']) ?></span>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary"><i
                                                    class="bi bi-envelope"></i></div>
                                            <div>
                                                <small class="text-muted d-block">Email</small>
                                                <span
                                                    class="fw-medium"><?= htmlspecialchars($employee['Email'] ?? 'Chưa cập nhật') ?></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-4 h-100">
                                    <h6 class="text-uppercase text-secondary fw-bold small mb-3">Thống kê công việc</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i
                                                class="bi bi-check-circle"></i></div>
                                        <div>
                                            <small class="text-muted d-block">Trạng thái hiện tại</small>
                                            <span class="fw-bold text-success">Đang hoạt động</span>
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 bg-white shadow-sm mb-0 py-2 small">
                                        <i class="bi bi-info-circle me-1"></i> Tổng số tour đã tham gia:
                                        <strong><?= !empty($assignedTours) ? count($assignedTours) : 0 ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-pill me-2" style="width: 4px; height: 24px;"></div>
                                <h5 class="fw-bold text-dark mb-0">Lịch sử công tác</h5>
                            </div>

                            <div class="card border shadow-sm rounded-4 overflow-hidden">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4 py-3 text-secondary small fw-bold">Tên Tour</th>
                                                <th class="py-3 text-secondary small fw-bold">Thời gian</th>
                                                <th class="py-3 text-secondary small fw-bold text-end pe-4">Trạng thái
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($assignedTours)): ?>
                                            <?php foreach ($assignedTours as $tour): ?>
                                            <?php 
                                                        $today = date('Y-m-d');
                                                        $statusBadge = '';
                                                        $statusText = '';
                                                        
                                                        if ($today > $tour['EndDate']) {
                                                            $statusBadge = 'bg-success-subtle text-success';
                                                            $statusText = 'Hoàn thành';
                                                        } elseif ($today >= $tour['StartDate'] && $today <= $tour['EndDate']) {
                                                            $statusBadge = 'bg-danger-subtle text-danger';
                                                            $statusText = 'Đang diễn ra';
                                                        } else {
                                                            $statusBadge = 'bg-info-subtle text-info-emphasis';
                                                            $statusText = 'Sắp tới';
                                                        }
                                                    ?>
                                            <tr>
                                                <td class="ps-4 fw-medium text-dark">
                                                    <?= htmlspecialchars($tour['TourName']) ?>
                                                </td>
                                                <td class="small text-muted">
                                                    <?= date('d/m/Y', strtotime($tour['StartDate'])) ?> -
                                                    <?= date('d/m/Y', strtotime($tour['EndDate'])) ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <span
                                                        class="badge rounded-pill <?= $statusBadge ?> border border-opacity-10 px-3 py-2">
                                                        <?= $statusText ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">
                                                    <i class="bi bi-calendar-x mb-2 d-block fs-3 opacity-25"></i>
                                                    Chưa có lịch sử nhận tour.
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <a href="<?= BASE_URL ?>?act=editEmployee&id=<?= $employee['EmployeeID'] ?>"
                                class="btn btn-warning px-4 fw-bold shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa hồ sơ
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --header-height: 70px;
    --sidebar-width: 260px;
}

body {
    background-color: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
    padding-top: var(--header-height);
}

.sidebar-wrapper {
    width: var(--sidebar-width);
    position: fixed;
    top: var(--header-height);
    bottom: 0;
    left: 0;
    z-index: 100;
    overflow-y: auto;
}

.admin-content {
    margin-left: var(--sidebar-width);
    min-height: calc(100vh - var(--header-height));
}

@media (max-width: 992px) {
    .sidebar-wrapper {
        margin-left: calc(var(--sidebar-width) * -1);
    }

    .admin-content {
        margin-left: 0;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>