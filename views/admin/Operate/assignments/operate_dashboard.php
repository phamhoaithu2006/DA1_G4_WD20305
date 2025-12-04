<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end" style="width: 260px; min-height: 100vh;">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fa;">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-1">Điều hành Tour</h2>
                <h5 class="text-dark fw-bold mb-1"><?= htmlspecialchars($tour['TourName']) ?></h5>
                <p class="text-muted small mb-2">
                    <i class="bi bi-calendar-event me-1"></i>
                    <?= date('d/m/Y', strtotime($tour['StartDate'])) ?> -
                    <?= date('d/m/Y', strtotime($tour['EndDate'])) ?>
                </p>

                <div class="d-flex align-items-center mt-3">
                    <span class="text-secondary small fw-bold me-2 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">Nhân sự phụ trách:</span>

                    <?php if (!empty($assignedStaffs)): ?>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php foreach ($assignedStaffs as $staff): ?>
                        <span
                            class="badge bg-white text-dark border shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                            <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-2"
                                style="width: 24px; height: 24px; font-size: 0.75rem;">
                                <?= strtoupper(substr($staff['FullName'], 0, 1)) ?>
                            </div>
                            <div class="d-flex flex-column text-start" style="line-height: 1.1;">
                                <span class="fw-bold"
                                    style="font-size: 0.85rem;"><?= htmlspecialchars($staff['FullName']) ?></span>
                                <span class="text-muted fst-italic"
                                    style="font-size: 0.7rem;"><?= htmlspecialchars($staff['Role']) ?></span>
                            </div>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <span
                        class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2">
                        <i class="bi bi-exclamation-circle me-1"></i> Chưa phân công HDV
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="?act=schedule" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#services"><i class="bi bi-bag-check"></i>
                    Dịch vụ & Booking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#itinerary"><i class="bi bi-map"></i> Lịch trình
                    chi tiết</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#customers"><i class="bi bi-people"></i> Danh
                    sách khách</a>
            </li>
        </ul>

        <div class="tab-content mt-4 bg-white p-4 rounded shadow-sm" style="min-height: 500px;">

            <div class="tab-pane fade show active" id="services">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="text-secondary">Danh sách dịch vụ cần đặt</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="bi bi-plus-lg"></i> Thêm Booking mới
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Loại DV</th>
                                <th>Nhà cung cấp</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($services)): ?>
                            <?php foreach ($services as $sv): ?>
                            <tr>
                                <td><span
                                        class="fw-bold text-primary"><?= htmlspecialchars($sv['ServiceType']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($sv['SupplierName'] ?? 'Chưa xác định') ?></td>
                                <td class="text-center"><?= $sv['Quantity'] ?></td>
                                <td class="text-end"><?= number_format($sv['Price'], 0, ',', '.') ?> đ</td>
                                <td><small class="text-muted"><?= htmlspecialchars($sv['Note']) ?></small></td>
                                <td class="text-center">
                                    <?php 
                                            if($sv['Status'] == 0) echo '<span class="badge bg-secondary">Mới tạo</span>';
                                            elseif($sv['Status'] == 1) echo '<span class="badge bg-warning text-dark">Đã gửi mail</span>';
                                            elseif($sv['Status'] == 2) echo '<span class="badge bg-success">Đã xác nhận</span>';
                                        ?>
                                </td>
                                <td class="text-center">
                                    <form action="?act=service-status-update" method="POST" style="display:inline;">
                                        <input type="hidden" name="service_id" value="<?= $sv['ServiceID'] ?>">
                                        <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                                        <?php if($sv['Status'] == 0): ?>
                                        <button name="status" value="1" class="btn btn-sm btn-info text-white"><i
                                                class="bi bi-envelope"></i> Gửi</button>
                                        <?php elseif($sv['Status'] == 1): ?>
                                        <button name="status" value="2" class="btn btn-sm btn-success"><i
                                                class="bi bi-check"></i> Duyệt</button>
                                        <?php else: ?>
                                        <span class="text-success"><i class="bi bi-check-all"></i> Xong</span>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Chưa có dịch vụ nào.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="itinerary">
                <div class="d-flex justify-content-between mb-4 mt-2">
                    <h5 class="text-secondary">Chi tiết lịch trình theo ngày</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItineraryModal">
                        <i class="bi bi-plus-lg"></i> Thêm hoạt động
                    </button>
                </div>

                <?php if (!empty($groupedItinerary)): ?>
                <?php foreach ($groupedItinerary as $day => $items): ?>
                <div class="card mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="fw-bold text-primary mb-0 text-uppercase"><i
                                class="bi bi-calendar-date me-2"></i>Ngày thứ <?= $day ?></h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($items as $item): ?>
                            <div class="list-group-item p-3 border-bottom-0 border-top">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center border-end">
                                        <div class="fw-bold text-dark fs-5">
                                            <?= date('H:i', strtotime($item['TimeStart'])) ?></div>
                                    </div>
                                    <div class="col-md-9 ps-4">
                                        <h6 class="fw-bold text-dark mb-1">
                                            <?= htmlspecialchars($item['Title']) ?>
                                            <?php if(!empty($item['Location'])): ?>
                                            <span class="badge bg-white text-secondary border fw-normal ms-2 shadow-sm">
                                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                                <?= htmlspecialchars($item['Location']) ?>
                                            </span>
                                            <?php endif; ?>
                                        </h6>
                                        <p class="text-secondary mb-0 small">
                                            <?= nl2br(htmlspecialchars($item['Content'])) ?></p>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <a href="?act=itinerary-delete&id=<?= $item['ItineraryID'] ?>&tour_id=<?= $tour['TourID'] ?>"
                                            class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                            onclick="return confirm('Xóa hoạt động này?')"><i
                                                class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="text-center py-5 text-muted bg-light rounded-3">
                    <i class="bi bi-map fs-1 d-block mb-3 opacity-50"></i>
                    <p>Chưa có lịch trình chi tiết.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade" id="customers">
                <div class="d-flex justify-content-between mb-3 mt-3">
                    <h5 class="text-secondary">Danh sách đoàn khách</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <i class="bi bi-person-plus-fill"></i> Xếp phòng / Thêm khách
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">STT</th>
                                <th>Họ và tên</th>
                                <th>Liên hệ</th>
                                <th class="text-center">Số phòng</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $i => $cus): ?>
                            <tr>
                                <td class="text-center"><?= $i + 1 ?></td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($cus['FullName']) ?></div>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($cus['Phone']) ?><br>
                                        <i class="bi bi-envelope me-1"></i>
                                        <?= htmlspecialchars($cus['Email'] ?? '-') ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($cus['RoomNumber'])): ?>
                                    <span
                                        class="badge bg-info text-dark border"><?= htmlspecialchars($cus['RoomNumber']) ?></span>
                                    <?php else: ?>
                                    <span class="text-muted small">Chưa xếp</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small"><?= htmlspecialchars($cus['Note']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted bg-light">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                    Chưa có khách nào trong danh sách đoàn.
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

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Booking / Dịch vụ</h5><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <form action="?act=service-add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                    <div class="mb-3"><label class="form-label">Loại dịch vụ</label><select name="service_type"
                            class="form-select">
                            <option value="Khách sạn">Khách sạn</option>
                            <option value="Nhà hàng">Nhà hàng</option>
                            <option value="Xe vận chuyển">Xe vận chuyển</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Nhà cung cấp (ID)</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">-- Chọn NCC (Nếu có) --</option>
                            <?php if (!empty($suppliers)): ?>
                            <?php foreach ($suppliers as $sup): ?>
                            <option value="<?= $sup['SupplierID'] ?>"><?= htmlspecialchars($sup['SupplierName']) ?>
                            </option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3"><label>Số lượng</label><input type="number" name="quantity"
                                class="form-control" value="1"></div>
                        <div class="col-6 mb-3"><label>Giá dự kiến</label><input type="number" name="price"
                                class="form-control"></div>
                    </div>
                    <div class="mb-3"><label>Ghi chú</label><textarea name="note" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Lưu</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addItineraryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm hoạt động</h5><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <form action="?act=itinerary-add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">
                    <div class="row mb-3">
                        <div class="col-6"><label>Ngày thứ</label><input type="number" name="day_number"
                                class="form-control" value="1"></div>
                        <div class="col-6"><label>Giờ</label><input type="time" name="time_start" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3"><label>Tiêu đề</label><input type="text" name="title" class="form-control"
                            required></div>
                    <div class="mb-3"><label>Địa điểm</label><input type="text" name="location" class="form-control">
                    </div>
                    <div class="mb-3"><label>Nội dung</label><textarea name="content" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Lưu</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xếp khách vào đoàn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="?act=tour-customer-add" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Chọn khách từ Booking</label>
                        <select name="booking_customer" class="form-select" required>
                            <option value="">-- Chọn khách --</option>
                            <?php if (!empty($bookings) && is_array($bookings)): ?>
                            <?php foreach ($bookings as $b): ?>
                            <option value="<?= $b['CustomerID'] ?>-<?= $b['BookingID'] ?? 0 ?>">
                                <?= htmlspecialchars($b['FullName']) ?> (Booking #<?= $b['BookingID'] ?? '?' ?>)
                            </option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số phòng</label>
                        <input type="text" name="room_number" class="form-control" placeholder="Ví dụ: 305">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu danh sách</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>