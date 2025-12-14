<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fa;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">Báo cáo sau Tour: <?= htmlspecialchars($tour['TourName']) ?></h4>
                <div class="text-muted small">ID: #<?= $tour['TourID'] ?> | Kết thúc:
                    <?= date('d/m/Y', strtotime($tour['EndDate'])) ?></div>
            </div>
            <a href="?act=category" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay
                lại</a>
        </div>

        <ul class="nav nav-pills nav-fill mb-4 bg-white rounded shadow-sm p-1" id="reportTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#tab-logs">
                    <i class="bi bi-journal-text me-2"></i>Diễn biến & Sự cố
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-feedback">
                    <i class="bi bi-chat-heart me-2"></i>Phản hồi khách hàng
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-eval">
                    <i class="bi bi-person-check me-2"></i>Đánh giá nhân sự
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="tab-logs">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white fw-bold">Nhật ký hành trình (Cập nhật bởi Hướng dẫn viên)</div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Người ghi</th>
                                                <th>Nội dung</th>
                                                <th>Sự cố</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($logs)): foreach ($logs as $log): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="fw-bold"><?= date('H:i', strtotime($log['LogDate'])) ?>
                                                            </div>
                                                            <div class="small text-muted">
                                                                <?= date('d/m', strtotime($log['LogDate'])) ?></div>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-light text-dark border"><?= htmlspecialchars($log['ReporterName']) ?></span>
                                                        </td>
                                                        <td>
                                                            <?= nl2br(htmlspecialchars($log['Note'])) ?>
                                                            <?php if (!empty($log['Images'])):
                                                                $imgs = json_decode($log['Images'], true);
                                                                if ($imgs): ?>
                                                                    <div class="d-flex gap-1 mt-2">
                                                                        <?php foreach ($imgs as $img): ?>
                                                                            <img src="<?= $img ?>"
                                                                                style="width:50px; height:50px; object-fit:cover;"
                                                                                class="rounded border">
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                            <?php endif;
                                                            endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($log['Incident'])): ?>
                                                                <div class="alert alert-danger py-1 px-2 mb-0 small">
                                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                                    <?= htmlspecialchars($log['Incident']) ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="text-success small"><i class="bi bi-check"></i> Ổn
                                                                    định</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;
                                            else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">Chưa có nhật ký nào</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Tóm tắt sự cố</h6>
                                <div class="alert alert-light border">
                                    <strong>Tổng sự cố ghi nhận:</strong>
                                    <span class="text-danger fw-bold fs-5 ms-2">
                                        <?= count(array_filter($logs, fn($l) => !empty($l['Incident']))) ?>
                                    </span>
                                </div>
                                <p class="small text-muted text-justify">
                                    Lưu ý: Các sự cố về sức khỏe, hỏng xe, mất đồ cần được lập biên bản riêng và lưu trữ
                                    tại bộ phận pháp chế/điều hành.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-feedback">
                <div class="d-flex align-items-center mb-4">
                    <div class="display-4 fw-bold text-warning me-3"><?= $avgRating ?></div>
                    <div>
                        <div class="text-warning">
                            <?php for ($i = 1; $i <= 5; $i++) echo $i <= round($avgRating) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                        </div>
                        <div class="text-muted small">Dựa trên <?= count($feedbacks) ?> lượt đánh giá</div>
                    </div>
                </div>

                <div class="row g-4">
                    <?php if (!empty($feedbacks)): foreach ($feedbacks as $fb): ?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($fb['FullName']) ?></h6>
                                            <div class="text-warning small">
                                                <?php for ($i = 1; $i <= 5; $i++) echo $i <= $fb['Rating'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                                            </div>
                                        </div>
                                        <p class="card-text text-secondary fst-italic">"<?= htmlspecialchars($fb['Comment']) ?>"
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted"><?= date('d/m/Y', strtotime($fb['CreatedAt'])) ?></small>
                                            <span class="badge bg-light text-dark border"><?= $fb['Type'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <div class="col-12 text-center py-5 text-muted">Chưa có phản hồi nào từ khách hàng</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-eval">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white fw-bold">Form đánh giá (Dành cho Quản lý)</div>
                            <div class="card-body">
                                <form action="?act=evaluate-staff" method="POST">
                                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Chọn Nhân sự</label>
                                        <select name="employee_id" class="form-select" required>
                                            <option value="">-- Chọn nhân viên --</option>
                                            <?php foreach ($staffs as $s): ?>
                                                <option value="<?= $s['EmployeeID'] ?>">
                                                    <?= $s['FullName'] ?> (<?= $s['TourRole'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Điểm số (Thang 10)</label>
                                        <input type="number" name="score" class="form-control" min="1" max="10"
                                            step="0.5" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nhận xét/Rút kinh nghiệm</label>
                                        <textarea name="note" class="form-control" rows="4"
                                            placeholder="Thái độ phục vụ, xử lý tình huống..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Lưu đánh giá</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white fw-bold">Lịch sử đánh giá tour này</div>
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nhân viên</th>
                                            <th class="text-center">Điểm</th>
                                            <th>Nhận xét</th>
                                            <th>Người chấm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($evaluations)): foreach ($evaluations as $ev): ?>
                                                <tr>
                                                    <td class="fw-bold text-primary"><?= htmlspecialchars($ev['EmpName']) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge <?= $ev['Score'] >= 8 ? 'bg-success' : ($ev['Score'] >= 5 ? 'bg-warning' : 'bg-danger') ?>">
                                                            <?= $ev['Score'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="small text-secondary"><?= htmlspecialchars($ev['Note']) ?></td>
                                                    <td class="small text-muted">
                                                        <?= htmlspecialchars($ev['AdminName'] ?? 'Admin') ?></td>
                                                </tr>
                                            <?php endforeach;
                                        else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Chưa có đánh giá nào
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>