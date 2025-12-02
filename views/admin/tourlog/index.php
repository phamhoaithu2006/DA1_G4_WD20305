<?php
ob_start();
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : 0;
$encodedTourID = urlencode($tourID);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Nhật ký Tour <span class="text-primary">#<?php echo htmlspecialchars($tourID); ?></span></h3>
    <a class="btn btn-success" href="index.php?act=tourlog-create&tourID=<?php echo $encodedTourID; ?>">
        <i class="bi bi-plus-circle"></i> Thêm nhật ký
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>LogID</th>
                    <th>Ngày</th>
                    <th>Người ghi</th>
                    <th>Nội dung</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): foreach ($logs as $l): ?>
                        <tr>
                            <td><?php echo $l['LogID']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($l['LogDate'])); ?></td>
                            <td><?php echo htmlspecialchars($l['EmployeeName'] ?? ''); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($l['Note'] ?? '')); ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning me-1" href="index.php?act=tourlog-edit&id=<?php echo $l['LogID']; ?>"><i class="bi bi-pencil-square"></i> Sửa</a>
                                <a class="btn btn-sm btn-danger" href="index.php?act=tourlog-delete&id=<?php echo $l['LogID']; ?>&tourID=<?php echo $encodedTourID; ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');"><i class="bi bi-trash"></i> Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Chưa có nhật ký.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require 'layout.php';
?>