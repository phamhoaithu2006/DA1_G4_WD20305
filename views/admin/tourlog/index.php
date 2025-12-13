<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Nhật ký nhân sự</h2>
                <p class="text-muted mb-0">Danh sách các nhật ký được ghi cho Tour #<?= $tourID ?></p>
            </div>

            <a href="<?= BASE_URL ?>?act=tourlog-create&tourID=<?= $tourID ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm nhật ký mới
            </a>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">ID</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Ngày ghi</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Nhân viên</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Ghi chú</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Sự cố</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Hình ảnh</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small fw-bold text-center">Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#<?= $log['LogID'] ?></td>

                                        <td class="text-muted small">
                                            <i class="bi bi-clock me-1"></i>
                                            <?= date('d/m/Y H:i', strtotime($log['LogDate'])) ?>
                                        </td>

                                        <td class="fw-semibold text-dark">
                                            <?= htmlspecialchars($log['FullName'] ?? 'N/A') ?>
                                        </td>

                                        <td class="text-dark">
                                            <?= nl2br(htmlspecialchars($log['Note'] ?? '')) ?>
                                        </td>

                                        <td class="fw-bold text-danger">
                                            <?= htmlspecialchars($log['Incident'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?php if (!empty($log['Images'])): ?>
                                                <img src="<?= $log['Images'] ?>"
                                                    class="rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <span class="text-muted">Không có ảnh</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center pe-4">
                                            <a href="<?= BASE_URL ?>?act=tourlog-edit&id=<?= $log['LogID'] ?>"
                                                class="btn btn-sm btn-light border text-warning shadow-sm me-1">
                                                <i class="bi bi-pencil-square"></i> Sửa
                                            </a>

                                            <a href="<?= BASE_URL ?>?act=tourlog-delete&id=<?= $log['LogID'] ?>&tourID=<?= $tourID ?>"
                                                class="btn btn-sm btn-light border text-danger shadow-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa nhật ký này?')">
                                                <i class="bi bi-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="fs-1 text-light-emphasis mb-2"><i class="bi bi-journal-x"></i></div>
                                        Chưa có nhật ký nào cho Tour này
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <a href="<?= BASE_URL ?>?act=schedule" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách Tour
        </a>

    </div>
</div>