<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4 bg-light">
        <div class="container-fluid" style="max-width: 800px;">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Cập nhật Nhà cung cấp</h5>
                </div>
                <div class="card-body p-4">
                    <form action="?act=supplier-update&id=<?= $supplier['SupplierID'] ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Nhà cung cấp</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= htmlspecialchars($supplier['SupplierName']) ?>"
                                placeholder="VD: Khách sạn Mường Thanh...">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Loại hình dịch vụ</label>
                                <select name="type" class="form-select">
                                    <option value="Khách sạn"
                                        <?= $supplier['ServiceTypes'] == 'Khách sạn' ? 'selected' : '' ?>>
                                        Khách sạn / Lưu trú
                                    </option>
                                    <option value="Xe vận chuyển"
                                        <?= $supplier['ServiceTypes'] == 'Xe vận chuyển' ? 'selected' : '' ?>>
                                        Xe vận chuyển
                                    </option>
                                    <option value="Nhà hàng"
                                        <?= $supplier['ServiceTypes'] == 'Nhà hàng' ? 'selected' : '' ?>>
                                        Nhà hàng / Ăn uống
                                    </option>
                                    <option value="Vé tham quan"
                                        <?= $supplier['ServiceTypes'] == 'Vé tham quan' ? 'selected' : '' ?>>
                                        Vé tham quan
                                    </option>
                                    <option value="Khác" <?= $supplier['ServiceTypes'] == 'Khác' ? 'selected' : '' ?>>
                                        Khác
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Thông tin liên hệ</label>
                                <input type="text" name="contact" class="form-control" required
                                    value="<?= htmlspecialchars($supplier['ContactInfo']) ?>"
                                    placeholder="SĐT hoặc Email...">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control"
                                rows="3"><?= htmlspecialchars($supplier['Address'] ?? '') ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="?act=suppliers" class="btn btn-light">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>