<?php
// PHP Logic: Nhóm Tour theo Tháng/Năm
$groupedByMonth = [];
if (!empty($tours)) {
    foreach ($tours as $tour) {
        $monthYear = date('Y-m', strtotime($tour['StartDate']));
        $groupedByMonth[$monthYear][] = $tour;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fc;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Lịch khởi hành tổng</h2>
                <p class="text-muted mb-0">Theo dõi các tour sắp tới, đã phân công và trạng thái dịch vụ</p>
            </div>
            <a href="?act=category" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-calendar-plus me-1"></i> Tạo Tour mới
            </a>
        </div>

        <?php if (!empty($groupedByMonth)): ?>

            <?php
            $currentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            foreach ($groupedByMonth as $monthYear => $tourList):
                $dateObj = DateTime::createFromFormat('Y-m', $monthYear);
            ?>
                <div class="schedule-group mb-5">

                    <h5 class="fw-bold text-dark mb-3">
                        <span class="bg-light text-primary p-2 rounded-3 shadow-sm me-2">
                            <i class="bi bi-calendar-range"></i>
                        </span>
                        Tháng <?= $dateObj->format('m/Y') ?>
                    </h5>

                    <div class="row g-4">
                        <?php foreach ($tourList as $tour):
                            $startDate = new DateTime($tour['StartDate']);

                            // Logic Trạng thái
                            $statusText = 'Sắp khởi hành';
                            $statusClass = 'bg-info';
                            if ($startDate <= $currentDate) {
                                $statusText = 'Đang diễn ra';
                                $statusClass = 'bg-danger';
                            }
                        ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card h-100 border-0 shadow-sm rounded-4">
                                    <div class="card-body p-4">

                                        <span class="badge <?= $statusClass ?> mb-3 shadow-sm rounded-pill">
                                            <?= $statusText ?>
                                        </span>

                                        <h5 class="card-title fw-bold text-dark mb-3">
                                            <?= htmlspecialchars($tour['TourName']) ?>
                                        </h5>

                                        <div class="vstack gap-2 small text-secondary mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-calendar-event me-2 text-primary"></i>
                                                <span>**Khởi hành: ** <?= date('d/m/Y', strtotime($tour['StartDate'])) ?></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-calendar-check me-2 text-danger"></i>
                                                <span>**Kết thúc:** <?= date('d/m/Y', strtotime($tour['EndDate'])) ?></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person-badge me-2 text-success"></i>
                                                <span>Hướng dẫn viên: Đã phân công (Giả định)</span>
                                            </div>
                                        </div>

                                        <a href="?act=operate-tour&id=<?= $tour['TourID'] ?>"
                                            class="btn btn-warning w-100 fw-bold shadow-sm mt-auto">
                                            <i class="bi bi-gear-fill me-1"></i> Vào điều hành
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="text-center py-5 card border-0 shadow-sm">
                <div class="mb-3 text-muted display-4"><i class="bi bi-calendar-x"></i></div>
                <h5 class="text-muted">Không tìm thấy lịch trình Tour nào sắp tới</h5>
                <p class="text-muted small">Vui lòng tạo Tour mới hoặc kiểm tra ngày khởi hành</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>