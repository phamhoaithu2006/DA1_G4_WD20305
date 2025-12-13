<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php require_once __DIR__ . '/../navbar.php'; ?>

<style>
    /* CSS cho Menu dính bên phải */
    .sticky-menu {
        position: sticky;
        top: 90px;
        z-index: 99;
    }

    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
        text-align: left;
        margin-bottom: 5px;
    }

    .nav-pills .nav-link.active {
        background-color: #e8f0fe;
        color: #0d6efd;
        font-weight: 700;
    }

    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .section-title {
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
    }

    /* Scroll margin để khi click menu không bị che khuất bởi navbar */
    .scroll-mt {
        scroll-margin-top: 100px;
    }
</style>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fc;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="?act=category" class="text-decoration-none">Quản lý
                                Tour</a></li>
                        <li class="breadcrumb-item active">Chi tiết Tour #<?= $tour['TourID'] ?></li>
                    </ol>
                </nav>
                <h4 class="fw-bold text-dark mb-0"><?= htmlspecialchars($tour['TourName']) ?></h4>
            </div>
            <div class="d-flex gap-2">
                <a href="?act=category" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left"></i>
                    Quay lại</a>
                <a href="?act=tour-edit&id=<?= $tour['TourID'] ?>" class="btn btn-primary shadow-sm"><i
                        class="bi bi-pencil-square"></i> Cập nhật</a>
            </div>
        </div>

        <?php if (!empty($tour)): ?>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                        <div class="card-body">
                            <div class="text-uppercase small fw-bold text-primary mb-1">Mã Tour</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">#<?= $tour['TourID'] ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                        <div class="card-body">
                            <div class="text-uppercase small fw-bold text-success mb-1">Giá cơ bản</div>
                            <div class="h5 mb-0 fw-bold text-gray-800"><?= number_format($tour['Price'], 0, ',', '.') ?> đ
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                        <div class="card-body">
                            <div class="text-uppercase small fw-bold text-info mb-1">Thời gian</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?= date('d/m', strtotime($tour['StartDate'])) ?> -
                                <?= date('d/m/Y', strtotime($tour['EndDate'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                        <div class="card-body">
                            <div class="text-uppercase small fw-bold text-warning mb-1">Nhà tổ chức</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?= htmlspecialchars($tour['SupplierName'] ?? 'Nội bộ') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-9">

                    <div id="section-info" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-dark section-title">Thông tin tổng quan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <img src="<?= htmlspecialchars($tour['Image']) ?>"
                                        class="img-fluid rounded shadow-sm w-100" style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <label class="fw-bold text-muted small text-uppercase mb-2">Mô tả Tour</label>
                                    <div class="text-secondary" style="white-space: pre-line; text-align: justify;">
                                        <?= ($tour['Description']) ? htmlspecialchars($tour['Description']) : 'Chưa có mô tả.' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="section-itinerary" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-dark section-title">Lịch trình chi tiết</h6>
                            <a href="?act=tour-itinerary-form&id=<?= $tour['TourID'] ?>"
                                class="btn btn-sm btn-primary-subtle text-primary fw-bold"><i class="bi bi-plus-lg"></i> Cập
                                nhật</a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($itinerary)): ?>
                                <div class="accordion" id="accordionItinerary">
                                    <?php foreach ($itinerary as $k => $item): ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button <?= $k == 0 ? '' : 'collapsed' ?>" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#day<?= $item['ItineraryID'] ?>">
                                                    <span class="badge bg-primary me-2">Ngày <?= $item['DayNumber'] ?></span>
                                                    <strong><?= htmlspecialchars($item['Title']) ?></strong>
                                                </button>
                                            </h2>
                                            <div id="day<?= $item['ItineraryID'] ?>"
                                                class="accordion-collapse collapse <?= $k == 0 ? 'show' : '' ?>"
                                                data-bs-parent="#accordionItinerary">
                                                <div class="accordion-body bg-light">
                                                    <p><?= nl2br(htmlspecialchars($item['Description'])) ?></p>
                                                    <div class="d-flex gap-4 mt-3 pt-3 border-top">
                                                        <div class="small"><i class="bi bi-house-door-fill text-warning"></i>
                                                            <strong>Lưu trú:</strong> <?= $item['Accommodation'] ?? 'N/A' ?>
                                                        </div>
                                                        <div class="small"><i class="bi bi-cup-hot-fill text-success"></i>
                                                            <strong>Ăn uống:</strong> <?= $item['Meals'] ?? 'N/A' ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning mb-0">Chưa có dữ liệu lịch trình</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="section-gallery" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-dark section-title">Thư viện ảnh</h6>
                        </div>
                        <div class="card-body">

                            <form action="?act=gallery-upload" method="POST" enctype="multipart/form-data" class="mb-4">
                                <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-secondary">Tải ảnh mới lên</label>
                                        <div class="input-group">
                                            <input type="file" name="gallery_images[]" class="form-control"
                                                id="galleryInput" multiple accept="image/*" required>
                                            <button type="submit" class="btn btn-primary fw-bold">
                                                <i class="bi bi-cloud-upload me-1"></i> Lưu ảnh
                                            </button>
                                        </div>
                                        <div class="form-text small">Giữ phím Ctrl để chọn nhiều ảnh cùng lúc</div>
                                    </div>
                                </div>
                            </form>
                            <hr class="text-muted opacity-25">

                            <div class="row g-3">
                                <?php if (!empty($gallery)): ?>
                                    <?php foreach ($gallery as $img): ?>
                                        <div class="col-6 col-md-3">
                                            <div class="position-relative group-image-hover">
                                                <img src="<?= BASE_URL . htmlspecialchars($img['ImageURL']) ?>"
                                                    class="img-fluid rounded shadow-sm w-100 border"
                                                    style="height: 120px; object-fit: cover;"
                                                    onerror="this.src='https://placehold.co/400x300?text=No+Image'"> <a
                                                    href='?act=delete-gallery-image&id=<?= $img['ImageID'] ?>&tour_id=<?= $tour['TourID'] ?>'
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 shadow-sm"
                                                    style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .4rem;"
                                                    onclick='return confirm("Xóa ảnh này?")'>
                                                    <i class="bi bi-x-lg"></i>
                                                </a>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-center text-muted py-4 bg-light rounded border border-dashed">
                                        <i class="bi bi-images display-6 mb-2 d-block text-secondary opacity-50"></i>
                                        Chưa có hình ảnh bổ sung.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div id="section-customers" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-dark section-title">Danh sách khách hàng</h6>
                            <span class="badge bg-primary rounded-pill"><?= isset($customers) ? count($customers) : 0 ?> Đơn
                                đặt</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Mã đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Liên hệ</th>
                                            <th>Ngày đặt</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end pe-3">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($customers)): foreach ($customers as $cus): ?>
                                                <tr>
                                                    <td class="ps-3 fw-bold text-primary">#<?= $cus['BookingID'] ?></td>
                                                    <td>
                                                        <div class="fw-bold text-dark"><?= htmlspecialchars($cus['FullName']) ?>
                                                        </div>
                                                        <?php if (isset($cus['GroupSize']) && $cus['GroupSize'] > 0): ?>
                                                            <small class="text-muted"><i class="bi bi-people-fill"></i> Nhóm
                                                                <?= $cus['GroupSize'] + 1 ?> người</small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="small">
                                                        <div><i class="bi bi-telephone me-1"></i>
                                                            <?= htmlspecialchars($cus['Phone']) ?></div>
                                                        <div class="text-muted"><i class="bi bi-envelope me-1"></i>
                                                            <?= htmlspecialchars($cus['Email']) ?></div>
                                                    </td>
                                                    <td class="small text-muted">
                                                        <?= date('d/m/Y', strtotime($cus['BookingDate'])) ?></td>
                                                    <td>
                                                        <?php
                                                        $badgeClass = 'bg-secondary';
                                                        if ($cus['Status'] == 'Đã xác nhận') $badgeClass = 'bg-info';
                                                        elseif ($cus['Status'] == 'Đã thanh toán') $badgeClass = 'bg-success';
                                                        elseif ($cus['Status'] == 'Đã hủy') $badgeClass = 'bg-danger';
                                                        elseif ($cus['Status'] == 'Đang xử lý') $badgeClass = 'bg-warning text-dark';
                                                        ?>
                                                        <span
                                                            class="badge <?= $badgeClass ?> bg-opacity-75"><?= $cus['Status'] ?></span>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                        <a href="?act=booking-detail&id=<?= $cus['BookingID'] ?>"
                                                            class="btn btn-sm btn-outline-primary border-0" data-bs-toggle="tooltip"
                                                            title="Xem chi tiết đơn">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">Chưa có khách hàng nào đặt
                                                    tour này</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="section-price" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-dark section-title">Bảng giá & Chính sách</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6 border-end">
                                    <h6 class="text-success small fw-bold text-uppercase mb-3">Bảng giá chi tiết</h6>
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Đối tượng</th>
                                                <th class="text-end">Giá (VNĐ)</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pricing)): foreach ($pricing as $p): ?>
                                                    <tr>
                                                        <td class="fw-bold"><?= htmlspecialchars($p['TouristType']) ?></td>
                                                        <td class="text-end text-danger fw-bold">
                                                            <?= number_format($p['Price'], 0, ',', '.') ?></td>
                                                        <td class="small"><?= htmlspecialchars($p['Description']) ?></td>
                                                    </tr>
                                                <?php endforeach;
                                            else: ?>
                                                <tr>
                                                    <td>Người lớn</td>
                                                    <td class="text-end"><?= number_format($tour['Price'], 0, ',', '.') ?></td>
                                                    <td>Mặc định</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-info small fw-bold text-uppercase mb-3">Điều khoản</h6>
                                    <ul class="list-group list-group-flush small">
                                        <li class="list-group-item px-0 pt-0">
                                            <strong>Giá bao gồm:</strong><br>
                                            <span
                                                class="text-muted"><?= nl2br(htmlspecialchars($tour['PolicyInclude'] ?? '---')) ?></span>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Hoàn/Hủy:</strong><br>
                                            <span
                                                class="text-muted"><?= nl2br(htmlspecialchars($tour['PolicyRefund'] ?? '---')) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="section-supplier" class="card border-0 shadow-sm mb-4 scroll-mt">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-dark section-title">Đối tác cung ứng</h6>
                            <a href="?act=service-add&tour_id=<?= $tour['TourID'] ?>"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-link"></i> Liên kết
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Dịch vụ</th>
                                            <th>Đơn vị</th>
                                            <th>Liên hệ</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($services)): foreach ($services as $s): ?>
                                                <tr>
                                                    <td class="ps-3"><span
                                                            class="badge bg-secondary"><?= htmlspecialchars($s['ServiceType']) ?></span>
                                                    </td>
                                                    <td class="fw-bold"><?= htmlspecialchars($s['SupplierName']) ?></td>
                                                    <td class="small"><?= htmlspecialchars($s['ContactInfo']) ?></td>
                                                    <td class="small text-muted"><?= htmlspecialchars($s['Note']) ?></td>
                                                </tr>
                                            <?php endforeach;
                                        else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">Chưa có dịch vụ liên kết
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card border-0 shadow-sm sticky-menu">
                        <div class="card-body">
                            <h6 class="fw-bold text-muted text-uppercase small mb-3">Mục lục nhanh</h6>
                            <nav class="nav nav-pills flex-column" id="tour-scrollspy">
                                <a class="nav-link" href="#section-info"><i class="bi bi-info-circle me-2"></i>Thông tin
                                    chung</a>
                                <a class="nav-link" href="#section-itinerary"><i class="bi bi-map me-2"></i>Lịch trình</a>
                                <a class="nav-link" href="#section-gallery"><i class="bi bi-images me-2"></i>Hình ảnh</a>
                                <a class="nav-link" href="#section-customers"><i class="bi bi-people me-2"></i>Khách
                                    hàng</a>
                                <a class="nav-link" href="#section-price"><i class="bi bi-cash-coin me-2"></i>Giá & Chính
                                    sách</a>
                                <a class="nav-link" href="#section-supplier"><i class="bi bi-building me-2"></i>Nhà cung
                                    cấp</a>
                            </nav>
                            <hr>
                            <div class="d-grid">
                                <a href="<?= BASE_URL ?>?act=category" class="btn btn-success fw-bold">
                                    <i class="bi bi-check2-circle me-1"></i> Hoàn tất xem
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <?php else: ?>
            <div class="alert alert-danger">Không tìm thấy thông tin tour</div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Kích hoạt ScrollSpy
    document.addEventListener("DOMContentLoaded", function() {
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#tour-scrollspy',
            offset: 120
        });

        // Kích hoạt Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>