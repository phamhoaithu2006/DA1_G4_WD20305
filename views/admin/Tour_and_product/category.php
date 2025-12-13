<?php
// === LOGIC MỚI: ƯU TIÊN TOUR SẮP TỚI ===

$grouped = [];
if (!empty($tours) && is_array($tours)) {
    
    // 1. Tách tour thành 2 nhóm: Active (Sắp chạy/Đang chạy) và Past (Đã xong)
    $activeTours = [];
    $pastTours = [];
    $today = date('Y-m-d');

    foreach ($tours as $tour) {
        // Nếu ngày kết thúc >= hôm nay => Vẫn còn hiệu lực (Sắp chạy hoặc Đang chạy)
        if ($tour['EndDate'] >= $today) {
            $activeTours[] = $tour;
        } else {
            $pastTours[] = $tour;
        }
    }

    // 2. Sắp xếp nhóm Active: Ngày bắt đầu gần nhất lên trước (ASC)
    usort($activeTours, function($a, $b) {
        return strtotime($a['StartDate']) - strtotime($b['StartDate']);
    });

    // 3. Sắp xếp nhóm Past: Tour vừa mới xong lên trước (DESC - theo StartDate hoặc EndDate)
    usort($pastTours, function($a, $b) {
        return strtotime($b['EndDate']) - strtotime($a['EndDate']);
    });

    // 4. Gộp lại: Active lên đầu, Past xuống dưới
    $sortedTours = array_merge($activeTours, $pastTours);

    // 5. Nhóm theo Category (Dữ liệu đã được sắp xếp sẵn)
    foreach ($sortedTours as $tour) {
        $grouped[$tour['CategoryName']][] = $tour;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    :root {
        --header-height: 70px;
        --sidebar-width: 260px;
        --primary-color: #4e73df;
    }

    body {
        background-color: #f8f9fc;
        font-family: 'Segoe UI', sans-serif;
        padding-top: var(--header-height);
    }

    /* Layout Admin */
    .sidebar-wrapper {
        width: var(--sidebar-width);
        position: fixed;
        top: var(--header-height);
        bottom: 0;
        left: 0;
        z-index: 100;
        background: white;
        border-right: 1px solid #e3e6f0;
    }

    .admin-content {
        margin-left: var(--sidebar-width);
        padding: 1.5rem;
        min-height: calc(100vh - var(--header-height));
    }

    /* Table Styles */
    .table-responsive {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .table th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        border-top: none;
    }

    .tour-thumbnail {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }

    .action-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
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
</head>

<body>

    <?php require_once __DIR__ . '/../navbar.php'; ?>

    <div class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content">
        <div class="container-fluid p-0">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="text-dark fw-bold mb-1">Quản lý Tour du lịch</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách Tour</li>
                        </ol>
                    </nav>
                </div>
                <a href="?act=tour-create" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm Tour mới
                </a>
            </div>

            <?php if (!empty($grouped)): ?>
            <?php foreach ($grouped as $categoryName => $tourList): ?>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header py-3 bg-white d-flex align-items-center border-bottom">
                    <i class="bi bi-folder2-open text-primary me-2 fs-5"></i>
                    <h6 class="m-0 font-weight-bold text-primary"><?= htmlspecialchars($categoryName) ?></h6>
                    <span class="badge bg-secondary ms-2 rounded-pill"><?= count($tourList) ?> tours</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 80px;">Hình ảnh</th>
                                    <th style="width: 25%;">Tên Tour</th>
                                    <th>Thời gian</th>
                                    <th>Giá & Khuyến mãi</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tourList as $tour): ?>
                                <?php
                                            // === GIỮ NGUYÊN LOGIC TÍNH TOÁN ===
                                            $currentDate = new DateTime();
                                            $startDate = new DateTime($tour['StartDate']);
                                            $endDate = new DateTime($tour['EndDate']);
                                            
                                            $statusBadge = '';
                                            $statusText = '';

                                            if ($currentDate > $endDate) {
                                                $statusBadge = 'bg-success-subtle text-success border border-success-subtle';
                                                $statusText = 'Hoàn thành';
                                            } elseif ($currentDate >= $startDate && $currentDate <= $endDate) {
                                                $statusBadge = 'bg-danger-subtle text-danger border border-danger-subtle'; // Admin alert style
                                                $statusText = 'Đang chạy';
                                            } else {
                                                $statusBadge = 'bg-info-subtle text-info border border-info-subtle';
                                                $statusText = 'Sắp chạy';
                                            }

                                            // Logic giá
                                            $originalPrice = $tour['Price'];
                                            $discount = 10;
                                            $discountedPrice = $originalPrice * (1 - $discount/100);
                                        ?>
                                <tr>
                                    <td class="text-center text-muted"><?= $tour['TourID'] ?></td>
                                    <td>
                                        <?php if (!empty($tour['Image'])): ?>
                                        <img src="<?= htmlspecialchars($tour['Image']) ?>"
                                            class="tour-thumbnail shadow-sm" alt="Tour img"
                                            onerror="this.src='https://via.placeholder.com/60x40?text=No+Img';">
                                        <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center border rounded"
                                            style="width: 60px; height: 40px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;"
                                            title="<?= htmlspecialchars($tour['TourName']) ?>">
                                            <?= htmlspecialchars($tour['TourName']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <i
                                                class="bi bi-building me-1"></i><?= htmlspecialchars($tour['SupplierName'] ?? 'N/A') ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <span><i
                                                    class="bi bi-calendar-event me-1 text-success"></i><?= date('d/m/Y', strtotime($tour['StartDate'])) ?></span>
                                            <span><i
                                                    class="bi bi-calendar-check me-1 text-danger"></i><?= date('d/m/Y', strtotime($tour['EndDate'])) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold text-primary"><?= number_format($discountedPrice, 0, ',', '.') ?>đ</span>
                                            <small class="text-muted text-decoration-line-through"
                                                style="font-size: 0.75rem;">
                                                <?= number_format($originalPrice, 0, ',', '.') ?>đ
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $statusBadge ?> rounded-pill px-2 py-1 fw-normal">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= BASE_URL ?>?act=detail&id=<?= $tour['TourID'] ?>"
                                                class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                                                title="Xem chi tiết">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>?act=operate-tour&id=<?= $tour['TourID'] ?>"
                                                class="btn btn-outline-warning" data-bs-toggle="tooltip"
                                                title="Điều hành">
                                                <i class="bi bi-gear-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php else: ?>
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-3 text-muted"><i class="bi bi-inbox fs-1"></i></div>
                    <h5 class="text-muted">Chưa có dữ liệu Tour nào</h5>
                    <a href="?act=tour-create" class="btn btn-sm btn-primary mt-2">Thêm Tour ngay</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Kích hoạt tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    </script>
</body>

</html>