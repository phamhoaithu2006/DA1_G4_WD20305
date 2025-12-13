<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout" style="min-height: 100vh;">

    <div class="sidebar-wrapper bg-white shadow-sm border-end" style="width: 280px; flex-shrink: 0;">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4 bg-light">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body text-center p-5">
                            <?php
                            $avatar = !empty($employee['Avatar']) ? $employee['Avatar'] : 'https://ui-avatars.com/api/?name=' . urlencode($employee['FullName']);
                            ?>
                            <img src="<?= $avatar ?>" class="rounded-circle shadow-sm mb-3" width="120" height="120"
                                style="object-fit: cover;">

                            <h4 class="fw-bold text-dark"><?= htmlspecialchars($employee['FullName']) ?></h4>
                            <span
                                class="badge bg-primary-subtle text-primary mb-2"><?= htmlspecialchars($employee['Role']) ?></span>
                            <div class="text-muted small mb-3"><?= htmlspecialchars($employee['Type'] ?? 'Nội địa') ?>
                            </div>

                            <div class="d-flex justify-content-center gap-2">
                                <a href="tel:<?= $employee['Phone'] ?>"
                                    class="btn btn-primary rounded-pill btn-sm px-3">
                                    <i class="bi bi-telephone"></i> Gọi
                                </a>
                                <a href="mailto:<?= $employee['Email'] ?>"
                                    class="btn btn-outline-secondary rounded-pill btn-sm px-3">
                                    <i class="bi bi-envelope"></i> Email
                                </a>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-3">
                            <div class="row text-center">
                                <div class="col border-end">
                                    <h6 class="fw-bold mb-0"><?= $employee['ExperienceYears'] ?? 0 ?></h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Năm kinh nghiệm</small>
                                </div>
                                <div class="col border-end">
                                    <h6 class="fw-bold mb-0"><?= count($assignedTours) ?></h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Tour đã dẫn</small>
                                </div>
                                <div class="col">
                                    <h6 class="fw-bold mb-0 text-warning">
                                        <?= $employee['Rating'] ?? '5.0' ?> <i class="bi bi-star-fill small"></i>
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Đánh giá</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Thông tin chi tiết</h6>
                            <ul class="list-unstyled small text-secondary mb-0">
                                <li class="mb-2"><i class="bi bi-cake2 me-2"></i> Ngày sinh:
                                    <span
                                        class="text-dark fw-medium"><?= !empty($employee['DateOfBirth']) ? date('d/m/Y', strtotime($employee['DateOfBirth'])) : '---' ?></span>
                                </li>
                                <li class="mb-2"><i class="bi bi-translate me-2"></i> Ngôn ngữ:
                                    <span
                                        class="text-dark fw-medium"><?= htmlspecialchars($employee['Languages'] ?? 'Tiếng Việt') ?></span>
                                </li>
                                <li class="mb-2"><i class="bi bi-award me-2"></i> Chứng chỉ: <br>
                                    <span
                                        class="text-dark fw-medium"><?= nl2br(htmlspecialchars($employee['Certificates'] ?? 'Chưa cập nhật')) ?></span>
                                </li>
                                <li><i class="bi bi-heart-pulse me-2"></i> Sức khỏe:
                                    <span
                                        class="text-dark fw-medium"><?= htmlspecialchars($employee['HealthStatus'] ?? 'Tốt') ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-success"></i>Lịch sử &
                                Phân công</h5>
                        </div>
                        <div class="card-body p-0 mt-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Tên Tour</th>
                                            <th>Thời gian</th>
                                            <th class="text-end pe-4">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($assignedTours)): ?>
                                            <?php foreach ($assignedTours as $t):
                                                $isCompleted = date('Y-m-d') > $t['EndDate'];
                                                $statusClass = $isCompleted ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis';
                                                $statusText = $isCompleted ? 'Hoàn thành' : 'Sắp tới/Đang chạy';
                                            ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <span
                                                            class="fw-bold text-dark d-block"><?= htmlspecialchars($t['TourName']) ?></span>
                                                    </td>
                                                    <td class="small text-muted">
                                                        <?= date('d/m', strtotime($t['StartDate'])) ?> -
                                                        <?= date('d/m/Y', strtotime($t['EndDate'])) ?>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <span
                                                            class="badge rounded-pill <?= $statusClass ?>"><?= $statusText ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    Chưa có lịch sử dẫn tour
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>