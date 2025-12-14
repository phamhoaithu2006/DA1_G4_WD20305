<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fa;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">Danh sách Nhà cung cấp</h4>
            <a href="?act=supplier-create" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm mới
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">ID</th>
                                <th class="py-3">Tên Nhà cung cấp</th>
                                <th class="py-3">Loại dịch vụ</th>
                                <th class="py-3">Liên hệ</th>
                                <th class="py-3">Địa chỉ</th>
                                <th class="text-end pe-4 py-3">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($suppliers)): foreach ($suppliers as $s): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">
                                    #<?= $s['SupplierID'] ?? $s['supplierid'] ?? '?' ?></td>

                                <td class="fw-bold text-dark">
                                    <?= htmlspecialchars($s['SupplierName'] ?? $s['suppliername'] ?? 'Không có tên') ?>
                                </td>

                                <td>
                                    <?php 
        // 1. Lấy giá trị từ các key có thể có (ưu tiên ServiceTypes)
        $serviceType = $s['ServiceTypes'] ?? $s['servicetypes'] ?? $s['Type'] ?? '';

        // 2. Kiểm tra nếu dữ liệu có thật sự tồn tại không
        if (!empty($serviceType)) {
            // Nếu CÓ dữ liệu -> Hiển thị Badge màu xanh
            echo '<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">' 
                 . htmlspecialchars($serviceType) 
                 . '</span>';
        } else {
            // Nếu KHÔNG có dữ liệu -> Hiển thị Badge màu xám "Chưa cập nhật"
            echo '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Chưa cập nhật</span>';
        }
    ?>
                                </td>

                                <td>
                                    <i class="bi bi-telephone-inbound me-1 text-muted"></i>
                                    <?= htmlspecialchars($s['ContactInfo'] ?? $s['contactinfo'] ?? '') ?>
                                </td>

                                <td class="small text-muted">
                                    <?= htmlspecialchars($s['Address'] ?? $s['address'] ?? '') ?>
                                </td>

                                <td class="text-end pe-4">
                                    <a href="?act=supplier-edit&id=<?= $s['SupplierID'] ?>"
                                        class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?act=supplier-delete&id=<?= $s['SupplierID'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa NCC này?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>