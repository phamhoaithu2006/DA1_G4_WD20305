<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fc;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Liên kết dịch vụ Tour</h4>
            <a href="javascript:history.back()" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="?act=service-store" method="POST">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Chọn Tour áp dụng <span
                                    class="text-danger">*</span></label>
                            <select name="tour_id" class="form-select" required>
                                <option value="">-- Chọn Tour --</option>
                                <?php foreach ($tours as $t): ?>
                                    <option value="<?= $t['TourID'] ?>"
                                        <?= (isset($preSelectedTourId) && $preSelectedTourId == $t['TourID']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t['TourName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nhà cung cấp <span class="text-danger">*</span></label>
                            <select name="supplier_id" class="form-select" required>
                                <option value="">-- Chọn NCC --</option>
                                <?php foreach ($suppliers as $s): ?>
                                    <option value="<?= $s['SupplierID'] ?>">
                                        <?= htmlspecialchars($s['SupplierName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Loại dịch vụ</label>
                            <select name="service_type" class="form-select">
                                <option value="Khách sạn">Khách sạn</option>
                                <option value="Nhà hàng">Nhà hàng</option>
                                <option value="Xe vận chuyển">Xe vận chuyển</option>
                                <option value="Vé tham quan">Vé tham quan</option>
                                <option value="Hướng dẫn viên">Hướng dẫn viên</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Số lượng</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Chi phí dự kiến (VNĐ)</label>
                            <input type="number" name="price" class="form-control" placeholder="Nhập giá tiền...">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Ghi chú chi tiết</label>
                            <textarea name="note" class="form-control" rows="3"
                                placeholder="VD: Phòng Twin, View biển, ăn chay..."></textarea>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="reset" class="btn btn-light me-2">Nhập lại</button>
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="bi bi-link-45deg me-1"></i> Lưu liên kết
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>