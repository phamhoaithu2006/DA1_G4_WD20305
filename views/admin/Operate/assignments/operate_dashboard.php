<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<style>
    /* CSS cho Menu dính bên phải */
    .sticky-menu {
        position: sticky;
        top: 90px;
        z-index: 99;
    }

    /* Style cho tiêu đề section */
    .section-title {
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
    }

    /* Scroll margin để không bị Header che khuất khi click menu */
    .scroll-mt {
        scroll-margin-top: 100px;
    }

    /* Tùy chỉnh Nav Pills bên phải */
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
        text-align: left;
        padding: 8px 15px;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.2s;
    }

    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .nav-pills .nav-link.active {
        background-color: #e8f0fe;
        color: #0d6efd;
        font-weight: 700;
    }
</style>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fa;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">Điều hành Tour: <?= htmlspecialchars($tour['TourName']) ?></h4>
                <div class="text-muted small mt-1">
                    <i class="bi bi-calendar-range me-1"></i> <?= date('d/m/Y', strtotime($tour['StartDate'])) ?>
                    <i class="bi bi-arrow-right mx-1"></i> <?= date('d/m/Y', strtotime($tour['EndDate'])) ?>
                </div>
            </div>
            <a href="?act=category" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Thoát
            </a>
        </div>

        <div class="row">

            <div class="col-lg-9">

                <div id="section-logistics" class="card border-0 shadow-sm mb-4 scroll-mt">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="m-0 fw-bold text-dark section-title">Kế hoạch & Điểm đón</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-7">
                                <form action="?act=update-logistics" method="POST">
                                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small text-uppercase fw-bold">Điểm tập
                                            trung</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i
                                                    class="bi bi-geo-alt text-danger"></i></span>
                                            <input type="text" name="meeting_point" class="form-control border-start-0"
                                                value="<?= htmlspecialchars($tour['MeetingPoint'] ?? '') ?>"
                                                placeholder="VD: Sân bay Tân Sơn Nhất..." required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small text-uppercase fw-bold">Thời gian tập
                                            trung</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i
                                                    class="bi bi-clock text-primary"></i></span>
                                            <input type="datetime-local" name="meeting_time"
                                                class="form-control border-start-0"
                                                value="<?= $tour['MeetingTime'] ? date('Y-m-d\TH:i', strtotime($tour['MeetingTime'])) : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                                        <i class="bi bi-save me-1"></i> Lưu kế hoạch
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <div class="alert alert-info h-100 border-0 bg-info-subtle rounded-3">
                                    <h6 class="text-info-emphasis fw-bold mb-3"><i
                                            class="bi bi-info-circle-fill me-2"></i>Lưu ý vận hành</h6>
                                    <ul class="small mb-0 text-secondary ps-3 vstack gap-2">
                                        <li>Kiểm tra danh sách khách trước 24h khởi hành.</li>
                                        <li>Gửi tin nhắn nhắc giờ tập trung cho khách (SMS/Zalo).</li>
                                        <li>Chuẩn bị banner đón đoàn và nước uống.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="section-hr" class="card border-0 shadow-sm mb-4 scroll-mt">
                    <div
                        class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <h6 class="m-0 fw-bold text-dark section-title">Đội ngũ Nhân sự</h6>
                        <button class="btn btn-sm btn-primary shadow-sm fw-bold px-3" data-bs-toggle="modal"
                            data-bs-target="#assignStaffModal">
                            <i class="bi bi-person-plus-fill me-1"></i> Phân công
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Vai trò</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Họ tên</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Liên hệ</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Trạng thái</th>
                                        <th class="text-end pe-4 py-3 text-secondary small fw-bold text-uppercase">Hành
                                            động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($assignedStaff)): foreach ($assignedStaff as $st): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">
                                                        <?= $st['AssignedRole'] ?>
                                                    </span>
                                                </td>
                                                <td class="fw-bold text-dark"><?= htmlspecialchars($st['FullName']) ?></td>
                                                <td>
                                                    <a href="tel:<?= $st['Phone'] ?>"
                                                        class="text-decoration-none text-muted small">
                                                        <i class="bi bi-telephone me-1"></i> <?= $st['Phone'] ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Đã thông báo
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="?act=remove-staff&id=<?= $st['AssignmentID'] ?>"
                                                        class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                                        onclick="return confirm('Gỡ nhân sự này?')" data-bs-toggle="tooltip"
                                                        title="Gỡ bỏ">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5 fst-italic">Chưa phân công
                                                nhân sự nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="section-services" class="card border-0 shadow-sm mb-4 scroll-mt">
                    <div
                        class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <h6 class="m-0 fw-bold text-dark section-title">Dịch vụ đã đặt</h6>
                        <button class="btn btn-sm btn-success shadow-sm fw-bold px-3" data-bs-toggle="modal"
                            data-bs-target="#addServiceModal">
                            <i class="bi bi-cart-plus-fill me-1"></i> Đặt dịch vụ
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Ngày dùng</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Loại dịch vụ</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Nhà cung cấp</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Chi tiết</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Trạng thái</th>
                                        <th class="text-end pe-4 py-3 text-secondary small fw-bold text-uppercase">Xử lý
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($services)): foreach ($services as $sv):
                                            $statusBadges = [
                                                0 => '<span class="badge bg-secondary-subtle text-secondary border">Mới tạo</span>',
                                                1 => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Đã gửi mail</span>',
                                                2 => '<span class="badge bg-success-subtle text-success border border-success-subtle">Đã xác nhận</span>',
                                                3 => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Đã hủy</span>'
                                            ];
                                    ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <?php
                                                    // Kiểm tra xem key ServiceDate có tồn tại và có dữ liệu không
                                                    $hasDate = isset($sv['ServiceDate']) && !empty($sv['ServiceDate']);
                                                    ?>
                                                    <div class="fw-bold text-dark">
                                                        <?= $hasDate ? date('d/m', strtotime($sv['ServiceDate'])) : '--/--' ?>
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.7rem;">Năm
                                                        <?= $hasDate ? date('Y', strtotime($sv['ServiceDate'])) : '----' ?>
                                                    </small>
                                                </td>
                                                <td class="fw-bold text-primary"><?= htmlspecialchars($sv['ServiceType']) ?>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($sv['SupplierName']) ?>
                                                    </div>
                                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>
                                                        <?= htmlspecialchars($sv['ContactInfo']) ?></small>
                                                </td>
                                                <td>
                                                    <div><strong>SL:</strong> <?= $sv['Quantity'] ?></div>
                                                    <small
                                                        class="text-muted fst-italic"><?= htmlspecialchars($sv['Note']) ?></small>
                                                </td>
                                                <td><?= $statusBadges[$sv['Status']] ?? '---' ?></td>
                                                <td class="text-end pe-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light border dropdown-toggle shadow-sm"
                                                            type="button" data-bs-toggle="dropdown">
                                                            Thao tác
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                            <li><a class="dropdown-item text-warning"
                                                                    href="?act=update-service-status&id=<?= $sv['ServiceID'] ?>&status=1&tour_id=<?= $tour['TourID'] ?>"><i
                                                                        class="bi bi-envelope me-2"></i>Gửi Mail yêu cầu</a>
                                                            </li>
                                                            <li><a class="dropdown-item text-success"
                                                                    href="?act=update-service-status&id=<?= $sv['ServiceID'] ?>&status=2&tour_id=<?= $tour['TourID'] ?>"><i
                                                                        class="bi bi-check-lg me-2"></i>Xác nhận (Ok)</a>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li><a class="dropdown-item text-danger"
                                                                    href="?act=update-service-status&id=<?= $sv['ServiceID'] ?>&status=3&tour_id=<?= $tour['TourID'] ?>"
                                                                    onclick="return confirm('Hủy dịch vụ này?')"><i
                                                                        class="bi bi-trash me-2"></i>Hủy bỏ</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5 fst-italic">Chưa có dịch vụ
                                                nào được đặt.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-3 d-none d-lg-block">
                <div class="card border-0 shadow-sm sticky-menu rounded-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-muted text-uppercase small mb-3 ls-1">Mục lục điều hành</h6>
                        <nav class="nav nav-pills flex-column gap-1" id="ops-scrollspy">
                            <a class="nav-link" href="#section-logistics"><i class="bi bi-geo-alt me-2"></i>Kế hoạch &
                                Điểm đón</a>
                            <a class="nav-link" href="#section-hr"><i class="bi bi-people me-2"></i>Nhân sự Tour</a>
                            <a class="nav-link" href="#section-services"><i class="bi bi-building me-2"></i>Dịch vụ &
                                Đối tác</a>
                        </nav>
                        <hr class="my-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm fw-bold"><i
                                    class="bi bi-file-earmark-pdf me-1"></i> Xuất lệnh điều xe</button>
                            <button class="btn btn-outline-success btn-sm fw-bold"><i class="bi bi-whatsapp me-1"></i>
                                Nhóm Zalo Tour</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="assignStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="?act=assign-staff" method="POST">
            <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Phân công nhân sự</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-secondary">Chọn vai trò</label>
                    <select name="role" class="form-select shadow-sm" id="roleSelect" onchange="filterStaff()">
                        <option value="Hướng dẫn viên">Hướng dẫn viên</option>
                        <option value="Tài xế">Tài xế</option>
                        <option value="Nhân viên điều hành">Hậu cần/Điều hành</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-secondary">Chọn nhân viên (Đang
                        rảnh)</label>
                    <select name="employee_id" class="form-select shadow-sm" id="staffSelect">
                        <option value="">-- Chọn nhân viên --</option>
                        <?php foreach ($availableGuides as $g): ?>
                            <option value="<?= $g['EmployeeID'] ?>" class="staff-option role-hdv"><?= $g['FullName'] ?>
                                (HDV)</option>
                        <?php endforeach; ?>
                        <?php foreach ($availableDrivers as $d): ?>
                            <option value="<?= $d['EmployeeID'] ?>" class="staff-option role-driver d-none">
                                <?= $d['FullName'] ?> (Tài xế)</option>
                        <?php endforeach; ?>
                        <?php foreach ($availableOps as $o): ?>
                            <option value="<?= $o['EmployeeID'] ?>" class="staff-option role-ops d-none">
                                <?= $o['FullName'] ?> (Điều hành)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu & Gửi thông báo</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="?act=add-service" method="POST">
            <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Đặt dịch vụ Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Loại dịch vụ</label>
                        <select name="service_type" class="form-select shadow-sm">
                            <option value="Khách sạn">Khách sạn</option>
                            <option value="Xe vận chuyển">Xe vận chuyển</option>
                            <option value="Nhà hàng">Nhà hàng</option>
                            <option value="Vé tham quan">Vé tham quan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Ngày sử dụng</label>
                        <input type="date" name="service_date" class="form-control shadow-sm"
                            value="<?= $tour['StartDate'] ?>" min="<?= $tour['StartDate'] ?>"
                            max="<?= $tour['EndDate'] ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Nhà cung cấp</label>
                        <select name="supplier_id" class="form-select shadow-sm">
                            <option value="">-- Chọn NCC --</option>
                            <?php foreach ($suppliers as $s): ?>
                                <option value="<?= $s['SupplierID'] ?>"><?= $s['SupplierName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Số lượng</label>
                        <input type="number" name="quantity" class="form-control shadow-sm" value="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Đơn giá dự kiến</label>
                        <input type="number" name="price" class="form-control shadow-sm" placeholder="VNĐ">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Ghi chú/Yêu cầu</label>
                        <textarea name="note" class="form-control shadow-sm" rows="3"
                            placeholder="VD: Phòng Twin, View biển..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-success px-4 fw-bold">Thêm dịch vụ</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // 1. Kích hoạt ScrollSpy
    document.addEventListener("DOMContentLoaded", function() {
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#ops-scrollspy',
            offset: 120
        });

        // Kích hoạt Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    // 2. Script lọc nhân viên
    function filterStaff() {
        const role = document.getElementById('roleSelect').value;
        const options = document.querySelectorAll('.staff-option');
        options.forEach(opt => opt.classList.add('d-none'));

        if (role === 'Hướng dẫn viên') document.querySelectorAll('.role-hdv').forEach(el => el.classList.remove('d-none'));
        if (role === 'Tài xế') document.querySelectorAll('.role-driver').forEach(el => el.classList.remove('d-none'));
        if (role === 'Nhân viên điều hành') document.querySelectorAll('.role-ops').forEach(el => el.classList.remove(
            'd-none'));

        document.getElementById('staffSelect').value = "";
    }
</script>