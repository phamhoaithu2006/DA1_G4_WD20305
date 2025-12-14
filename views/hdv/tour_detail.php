<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết Tour - Portal HDV</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
        --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --text-main: #2d3748;
    }

    body {
        background-color: #f3f4f6;
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding-top: 80px;
        padding-bottom: 120px;
        /* Tăng khoảng trống dưới cùng để không che nút Lưu */
        min-height: 100vh;
    }

    /* Glass Navbar */
    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
    }

    /* Section Title */
    .section-title {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 1rem;
        margin-top: 2rem;
        padding-left: 0.5rem;
        border-left: 4px solid #667eea;
    }

    /* Card Styling */
    .glass-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    /* Info Row */
    .info-row {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .icon-box {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #6366f1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* Customer Avatar */
    .customer-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--secondary-gradient);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(132, 250, 176, 0.3);
        position: relative;
    }

    /* Timeline Logs */
    .timeline-item {
        position: relative;
        padding-left: 25px;
        padding-bottom: 25px;
        border-left: 2px solid #e2e8f0;
    }

    .timeline-item:last-child {
        border-left: 2px solid transparent;
    }

    .timeline-dot {
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        border: 4px solid #667eea;
    }

    /* Action Buttons */
    .action-btn-lg {
        border: none;
        border-radius: 16px;
        padding: 15px;
        text-align: left;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s;
        height: 100%;
        cursor: pointer;
    }

    .action-btn-lg:active {
        transform: scale(0.98);
    }

    .action-btn-lg i {
        font-size: 1.8rem;
        margin-bottom: 8px;
        display: block;
    }

    .btn-diary {
        background: #e0e7ff;
        color: #4338ca;
    }

    .btn-checkin {
        background: #dcfce7;
        color: #16a34a;
    }

    /* Floating Action Button */
    .fab-container {
        position: fixed;
        bottom: 100px;
        right: 25px;
        z-index: 990;
        /* Đẩy lên trên thanh save bar */
    }

    .fab-btn {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        font-size: 24px;
        border: none;
        transition: transform 0.2s;
    }

    .fab-btn:active {
        transform: scale(0.9);
    }

    /* Sticky Save Bar */
    .sticky-save-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        border-top: 1px solid #e2e8f0;
        padding: 15px 20px;
        z-index: 1000;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Custom Switch Size */
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand fixed-top px-3">
        <div class="d-flex align-items-center w-100">
            <a href="?act=hdv-tour" class="btn btn-light rounded-circle shadow-sm me-3"
                style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-arrow-left text-dark"></i>
            </a>
            <div class="flex-grow-1" style="min-width: 0;">
                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Chi tiết hành trình
                </div>
                <div class="fw-bold text-dark text-truncate fs-6">
                    <?= htmlspecialchars($tour['TourName'] ?? 'Chi tiết Tour') ?>
                </div>
            </div>
            <div class="dropdown ms-2">
                <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2">
                    <li><button class="dropdown-item rounded-3 mb-1" data-bs-toggle="modal"
                            data-bs-target="#modalCheckInOut">
                            <i class="bi bi-qr-code-scan me-2 text-primary"></i>Check-in/Check-out
                        </button></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item rounded-3 text-danger" href="?act=hdv-logout"><i
                                class="bi bi-box-arrow-right me-2"></i>Thoát</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (!empty($_SESSION['hdv_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['hdv_success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['hdv_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['hdv_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($_SESSION['hdv_error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['hdv_error']); ?>
        <?php endif; ?>

        <h6 class="section-title">Tổng quan</h6>
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="badge rounded-pill px-3 py-2" style="background: #e9d8fd; color: #553c9a;">
                    <?= htmlspecialchars($tour['CategoryName'] ?? 'Tour') ?>
                </span>
                <div class="fs-5 fw-bold text-primary">
                    <?= number_format($tour['Price'] ?? 0, 0, ',', '.') ?> <small>đ</small>
                </div>
            </div>

            <div class="mb-3">
                <div class="info-row">
                    <div class="icon-box"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="small text-muted" style="font-size:0.75rem">Khởi hành</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($tour['StartDate'] ?? '') ?></div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="icon-box text-success"><i class="bi bi-buildings"></i></div>
                    <div>
                        <div class="small text-muted" style="font-size:0.75rem">Nhà cung cấp</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($tour['SupplierName'] ?? '') ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-light p-3 rounded-4 text-secondary small">
                <div class="fw-bold text-dark mb-1">Lịch trình sơ lược:</div>
                <?= nl2br(htmlspecialchars($tour['Description'] ?? 'Chưa có mô tả chi tiết.')) ?>
            </div>
        </div>

        <div class="row g-3 mb-2">
            <div class="col-6">
                <div class="action-btn-lg btn-diary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDiary">
                    <i class="bi bi-journal-plus"></i>
                    <span class="fw-bold d-block">Viết nhật ký</span>
                    <small class="opacity-75" style="font-size:0.7rem">Báo cáo tình hình</small>
                </div>
            </div>
            <div class="col-6">
                <div class="action-btn-lg btn-checkin shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#modalCheckInOut">
                    <i class="bi bi-geo-fill"></i>
                    <span class="fw-bold d-block">Check-in</span>
                    <small class="opacity-75" style="font-size:0.7rem">Đến và Rời điểm</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-end mt-4 mb-2">
            <h6 class="section-title m-0">Đoàn khách (<?= count($customers ?? []) ?>)</h6>
            <button class="btn btn-sm btn-white border rounded-pill text-primary fw-bold" type="button"
                data-bs-toggle="collapse" data-bs-target="#roomAssignForm">
                <i class="bi bi-door-open me-1"></i> Xếp phòng
            </button>
        </div>

        <div class="glass-card">
            <div class="collapse bg-light p-3 border-bottom" id="roomAssignForm">
                <form method="post" action="?act=hdv-room-save&id=<?= $tour['TourID'] ?>">
                    <div class="row g-2">
                        <?php if (!empty($customers)): foreach ($customers as $c): ?>
                        <div class="col-6 col-md-4">
                            <div class="input-group input-group-sm">
                                <span
                                    class="input-group-text bg-white border-0 fw-bold"><?= substr(trim($c['FullName']), 0, 8) ?>..</span>
                                <input type="text" name="room[<?= $c['CustomerID'] ?>]"
                                    value="<?= htmlspecialchars($c['RoomNumber'] ?? '') ?>"
                                    class="form-control border-0" placeholder="Số phòng">
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Lưu Phòng</button>
                    </div>
                </form>
            </div>

            <form method="post" action="?act=hdv-attendance-save&id=<?= $tour['TourID'] ?>" id="attendanceForm">
                <div class="list-group list-group-flush">
                    <?php if (!empty($customers)): foreach ($customers as $c): ?>
                    <div class="list-group-item p-3 border-bottom-0 border-top-0"
                        style="border-bottom: 1px solid #f1f5f9 !important;">
                        <div class="d-flex align-items-center gap-3">

                            <div class="customer-avatar flex-shrink-0 position-relative">
                                <?php $parts = explode(' ', $c['FullName']); echo substr(end($parts), 0, 1); ?>
                                <?php if (!empty($c['Vegetarian'])): ?>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"
                                    title="Ăn chay"></span>
                                <?php endif; ?>
                            </div>

                            <div class="flex-grow-1"
                                onclick="document.getElementById('check_<?= $c['CustomerID'] ?>').click()">
                                <div class="fw-bold text-dark mb-1">
                                    <?= htmlspecialchars($c['FullName']) ?>
                                    <button type="button" class="btn btn-link p-0 ms-2 text-muted"
                                        data-bs-toggle="modal" data-bs-target="#editModal<?= $c['CustomerID'] ?>"
                                        onclick="event.stopPropagation()">
                                        <i class="bi bi-pencil-square" style="font-size:0.9rem"></i>
                                    </button>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="tel:<?= $c['Phone'] ?>"
                                        class="badge bg-light text-secondary border text-decoration-none fw-normal"
                                        onclick="event.stopPropagation()">
                                        <i class="bi bi-telephone-fill me-1 text-success"></i>
                                        <?= htmlspecialchars($c['Phone']) ?>
                                    </a>
                                    <?php if(!empty($c['RoomNumber'])): ?>
                                    <span
                                        class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold">P:
                                        <?= htmlspecialchars($c['RoomNumber']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="check_<?= $c['CustomerID'] ?>" name="attendance[<?= $c['CustomerID'] ?>]"
                                    value="1" <?= !empty($c['AttendanceChecked']) ? 'checked' : '' ?>>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; else: ?>
                    <div class="p-5 text-center text-muted">
                        <p>Chưa có dữ liệu khách hàng</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="sticky-save-bar">
                    <div class="small text-muted">
                        Đã chọn: <span class="fw-bold text-primary fs-5" id="countSelected">0</span> /
                        <?= count($customers ?? []) ?>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-check2-all me-1"></i> Lưu điểm danh
                    </button>
                </div>
            </form>
        </div>

        <h6 class="section-title">Nhật ký</h6>
        <div class="glass-card p-4">
            <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $l): ?>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="fw-bold text-dark"><?= date('H:i', strtotime($l['LogDate'])) ?></span>
                        <span class="text-muted small ms-1"><?= date('d/m', strtotime($l['LogDate'])) ?></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown"><i
                                class="bi bi-three-dots"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li><a class="dropdown-item text-danger"
                                    href="?act=hdv-diary-delete&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>"
                                    onclick="return confirm('Xóa?')">Xóa</a></li>
                        </ul>
                    </div>
                </div>
                <div class="bg-light rounded-3 p-3 mb-2">
                    <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($l['Note'])) ?></p>
                </div>
                <?php if (!empty($l['Incident'])): ?>
                <div class="alert alert-danger border-0 d-flex align-items-start gap-2 shadow-sm p-2 small">
                    <i class="bi bi-exclamation-octagon-fill text-danger mt-1"></i>
                    <div><strong>Sự cố:</strong> <?= nl2br(htmlspecialchars($l['Incident'])) ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($l['Images'])): 
                        $images = json_decode($l['Images'], true);
                        if (!empty($images)): ?>
                <div class="d-flex gap-2 overflow-auto mt-2">
                    <?php foreach ($images as $img): ?>
                    <a href="<?= $img ?>" target="_blank">
                        <img src="<?= $img ?>" class="rounded-3 shadow-sm border"
                            style="width: 60px; height: 60px; object-fit: cover;">
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; endif; ?>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-journal-album display-4 opacity-25"></i>
                <p class="mt-2 small">Chưa có ghi chép nào.</p>
            </div>
            <?php endif; ?>
        </div>

    </div> <?php if (!empty($customers)): foreach ($customers as $c): ?>
    <div class="modal fade" id="editModal<?= $c['CustomerID'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Thông tin khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="?act=hdv-special-request-save&id=<?= $tour['TourID'] ?>">
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" value="<?= $c['CustomerID'] ?>">
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Họ và tên</label>
                            <input type="text" name="FullName" class="form-control"
                                value="<?= htmlspecialchars($c['FullName'] ?? '') ?>" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted text-uppercase fw-bold">Số điện thoại</label>
                                <input type="text" name="Phone" class="form-control"
                                    value="<?= htmlspecialchars($c['Phone'] ?? '') ?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted text-uppercase fw-bold">Phòng</label>
                                <input type="text" name="RoomNumber" class="form-control"
                                    value="<?= htmlspecialchars($c['RoomNumber'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="mb-3 bg-light p-3 rounded-3 d-flex justify-content-between align-items-center">
                            <label class="form-check-label fw-bold" for="veg<?= $c['CustomerID'] ?>"><i
                                    class="bi bi-flower1 me-2 text-success"></i>Ăn chay</label>
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="veg<?= $c['CustomerID'] ?>" name="vegetarian" value="1"
                                <?= !empty($c['Vegetarian']) ? 'checked' : '' ?>>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Sức khỏe / Lưu ý</label>
                            <textarea name="medical_condition" class="form-control"
                                rows="2"><?= htmlspecialchars($c['MedicalCondition'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Yêu cầu khác</label>
                            <textarea name="other_requests" class="form-control"
                                rows="2"><?= htmlspecialchars($c['OtherRequests'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Ghi chú riêng
                                (HDV)</label>
                            <textarea name="note" class="form-control bg-light"
                                rows="2"><?= htmlspecialchars($c['SpecialRequests'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; endif; ?>

    <div class="modal fade" id="modalDiary" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Viết nhật ký mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="?act=hdv-diary-save&id=<?= $tour['TourID'] ?>"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nội dung</label>
                            <textarea class="form-control bg-light border-0" name="note" rows="5"
                                placeholder="Mô tả hoạt động, cảm nhận..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Hình ảnh</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-danger">Sự cố (Nếu có)</label>
                            <textarea class="form-control border-danger-subtle" name="incident" rows="2"
                                placeholder="Hỏng xe, khách ốm..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary px-4">Lưu Nhật Ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCheckInOut" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <ul class="nav nav-pills w-100 nav-fill p-1 bg-light rounded-pill" id="checkinTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill" id="in-tab" data-bs-toggle="pill"
                                data-bs-target="#in-pane">Check-in (Đến)</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill" id="out-tab" data-bs-toggle="pill"
                                data-bs-target="#out-pane">Check-out (Rời)</button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="in-pane">
                            <form method="post" action="?act=hdv-checkin-save&id=<?= $tour['TourID'] ?>">
                                <div class="text-center my-3">
                                    <i class="bi bi-geo-alt-fill text-primary display-4"></i>
                                    <h5 class="fw-bold mt-2">Xác nhận đến điểm</h5>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="checkin_location"
                                        class="form-control form-control-lg text-center bg-light"
                                        placeholder="Nhập tên địa điểm..." required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="checkin_note" class="form-control" rows="2"
                                        placeholder="Ghi chú (Tùy chọn)..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Xác nhận
                                    Check-in</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="out-pane">
                            <form method="post" action="?act=hdv-checkout-save&id=<?= $tour['TourID'] ?>">
                                <div class="text-center my-3">
                                    <i class="bi bi-box-arrow-right text-danger display-4"></i>
                                    <h5 class="fw-bold mt-2">Xác nhận rời đi</h5>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="checkout_location"
                                        class="form-control form-control-lg text-center bg-light"
                                        placeholder="Nhập tên địa điểm..." required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="checkout_note" class="form-control" rows="2"
                                        placeholder="Ghi chú sự cố (nếu có)..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-pill">Xác nhận
                                    Check-out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button class="fab-btn" data-bs-toggle="modal" data-bs-target="#modalDiary">
            <i class="bi bi-pencil-square"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Script đếm số lượng người đã check
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.form-check-input[name^="attendance"]');
        const countSpan = document.getElementById('countSelected');

        function updateCount() {
            let count = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) count++;
            });
            if (countSpan) countSpan.textContent = count;
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCount);
        });

        // Run on init
        updateCount();
    });
    </script>
</body>

</html>